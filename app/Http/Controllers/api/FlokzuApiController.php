<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FlokzuApiController extends Controller
{
    public function getAllDataFromDatabase()
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'X-Api-Key' => '3e107df6c3060dd1e868b6256269522fa95e2a020b5a005f',
                'X-Username' => 'jcuadros@meltec.com.co'
            ])->post('https://app.flokzu.com/flokzuopenapi/api/v2/database/record', [
                'databaseName' => 'Lista de precios',
                'filters' => [
                    [
                        'columnName' => 'Fabricante',
                        'value' => "Cyrus"
                    ]
                ]
            ]);
            dd($response->json());

            $result = $response->body();

            return response()->json($result);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => 'error',
            ], 500);
        }
    }
}
