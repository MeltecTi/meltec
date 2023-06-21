<?php

namespace App\Http\Controllers\api\powerbi;

use App\Http\Controllers\Controller;
use App\Models\AppExternal;
use App\Models\KpiFlokzu;
use Exception;
use Illuminate\Http\Request;

class FetchDataController extends Controller
{
    public function kpisFlokzu(Request $request)
    {
        try {
            $client = $request->header('X-CLIENT-ID');

            $appAuthorization = AppExternal::where('client_id', $client)->first();

            if($appAuthorization == null) {
                throw new Exception('Cliente no autorizado', 401);
            }

            $token = str_replace('Bearer ', '', $request->header('Authorization'));
            
            if($appAuthorization->client_secret !== $token) {
                throw new Exception('Token de Cliente no Valido', 401);
            }

            $dataKPI = KpiFlokzu::all();

            return response()->json([
                'data' => $dataKPI,
            ], 200);
            
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], $e->getCode());
        }
    }
}
