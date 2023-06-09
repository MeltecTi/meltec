<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EnviameController extends Controller
{
    public function getSellers()
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'api-key' => 'D0WLKpYvtaPbJwO2F2SV6aEMW9BGj5',
            ])->get('https://api.enviame.io/api/s1/v1/marketplaces/58724/companies');

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
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], $e->getCode());
        }
    }

    public function postNewSeller(Request $request)
    {
        $data = [
            'name' => 'Bodega de prueba con API',
            'code' => '112233',
            'place' => 'Bogotá D.C',
            'full_address' => 'Calle 123 #45 - 66',
            'level1' => 'Bogotá D.C',
        ];

        try {
            $response = HTTP::withHeaders([
                'Accept' => 'application/json',
                'api-key' => env('API_ENVIAME_IO_PRUEBAS'),
            ])->post('https://stage.api.enviame.io/api/s1/v1/marketplaces/' . env('ID_ENVIAME_IO_PRUEBAS') . '/companies/21081/warehouses', $data);
            
            dd($response);

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
