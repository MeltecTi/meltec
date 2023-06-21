<?php

namespace App\Http\Controllers;

use Exception;
use Ramsey\Uuid\Uuid;
use App\Models\AppExternal;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TokensAppsController extends Controller
{
    public function generateAppToken(Request $request)
    {

        try {

            $user = auth()->user();
            $token = str_replace('Bearer ', '', $request->header('Authorization'));

            if ($user->api_token !== $token || !$user->isAdmin()) {
                throw new Exception('Error de violacion de seguridad', 401);
            }

            $appName = $request->input('application_name');

            $exist = AppExternal::where('application_name', $appName)->first();
            
            if($exist !== null) {
                throw new Exception('Ya existe un Token para esta app', 400);
            }
            
            $client_id = Uuid::uuid4()->toString();
            
            $client_secret = Str::random(64);

            $newApp = AppExternal::create([
                'application_name' => $appName,
                'client_id' => $client_id,
                'client_secret' => $client_secret,
            ]);

            if(!$newApp) {
                throw new Exception('Hubo un error al generar el Token', 500);
            }

            return response()->json([
                'client_id' => $client_id,
                'client_secret' => $client_secret
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
