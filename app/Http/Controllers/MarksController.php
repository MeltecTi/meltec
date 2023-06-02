<?php

namespace App\Http\Controllers;

use App\Models\Mark;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;

class MarksController extends Controller
{
    // Obtener los datos de la marca mediante el nombre
    public function getMarkByName(Request $request, string $name)
    {
        try {
            $user = Auth::user();
            $token = str_replace('Bearer ', '', $request->header('Authorization'));

            if ($user->api_token !== $token || !$user->isAdmin()) {
                throw new UnauthorizedException('Acceso no autorizado', 403);
            }

            $markName = Str::title($name);

            $dataMark = Mark::where('name', $markName)->get();

            //Control de seguridad

            if ($markName === '' || $markName === null) {
                throw new Exception('Campo Vacio', 404);
            }

            //Si la marca exista, devolver la instancia

            if ($dataMark->count() > 0) {

                return response()->json([
                    'success' => true,
                    'data' => $dataMark->first(),
                ], 200);
            }
            //Si no existe, crearla
            if ($markName !== '' || $markName !== null) {
                $createMark = Mark::create([
                    'name' => $markName,
                ]);

                if (!$createMark) {
                    throw new Exception('Hubo un error al crear la data, contacte con el administrador del Sitio', 503);
                }

                return response()->json([
                    'success' => true,
                    'data' => $createMark,
                    'message' => 'Marca Creada correctamente',
                ], 200);
            }
        } catch (UnauthorizedException $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], $e->getCode());
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], $e->getCode());
        }
    }
}
