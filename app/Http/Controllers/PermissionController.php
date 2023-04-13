<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    public function store(Request $request)
    {

        try {

            $user = Auth::user();
            $token = str_replace('Bearer ', '', $request->header('Authorization'));

            if ($user->api_token !== $token || !$user->isAdmin()) {
                throw new AuthorizationException('Error: Acceso no autorizado', 401);
            }

            $newPermission = DB::table('permissions')->insert($request->all());

            if (!$newPermission) {
                throw new Exception('Error al insertar los datos', 500);
            }

            return response()->json([
                'message' => 'Permiso Agregado',
                'success' => true
            ], 201);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ], 500);

        } catch (AuthorizationException $e) {

            return response()->json([
                'success' => false,
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ], 401);
        }
    }
}
