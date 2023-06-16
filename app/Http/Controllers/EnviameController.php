<?php

namespace App\Http\Controllers;

use Exception;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\UnauthorizedException;

class EnviameController extends Controller
{
    public function getSellers(Request $request)
    {
        try {

            $user = auth()->user();
            dd($user);
            $token = $token = str_replace('Bearer ', '', $request->header('Authorization'));

            if($token == null) {
                throw new UnauthorizedException('Solicitud no autorizada', 401);
            }

            if ($user->api_token !== $token || !$user->isAdmin()) {
                throw new UnauthorizedException('Error al obtener el token de Autorizacion', 401);
            }


            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'api-key' => env('API_ENVIAME_IO_PRUEBAS'),
            ])->get(env('URL_API_PRUEBAS') . 'api/s1/v1/marketplaces/' . env('ID_ENVIAME_IO_PRUEBAS') . '/companies');

            if ($response->status() === 401) {
                throw new Exception('Error, usuario no Autorizado', 401);
            }

            if (!$response->successful()) {
                throw new Exception('Error al Obtener los datos del Marketplace', 500);
            }


            $data = $response->json();

            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        } catch (Exception $e) {
            return new JsonResponse([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        } catch (UnauthorizedException $e) {
            return new JsonResponse([
                'success' => false,
                'error' => $e->getMessage(),
            ], $e->getCode());
        }
    }

    public function postNewSeller(Request $request)
    {

        $data = [
            'name' => $request->input('name'),
            'corporate_name' => $request->input('corporate_name'),
            'code' => $request->input('code'),
            'dni' => $request->input('dni'),
            'rule' => $request->input('rule'),
            // 'carrier_code' => $request->input('carrier_code'),
        ];


        try {
            $response = HTTP::withHeaders([
                'Accept' => 'application/json',
                'api-key' => env('API_ENVIAME_IO_PRUEBAS'),
                'Content-Type' => 'application/json',
            ])->post(env('URL_API_PRUEBAS') . 'api/s1/v1/marketplaces/' . env('ID_ENVIAME_IO_PRUEBAS') . '/companies', $data);


            if ($response->status() === 401) {
                throw new Exception('Error, usuario no Autorizado', 401);
            }

            if (!$response->successful()) {
                throw new Exception('Error al Crear la empresa', 500);
            }


            $result = $response->json();

            return response()->json([
                'success' => true,
                'message' => 'Empresa Creada Correctamente',
                'data' => $result,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], $e->getCode());
        }
    }
}
