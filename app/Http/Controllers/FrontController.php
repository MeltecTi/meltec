<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\FormularioContacto;
use Illuminate\Support\Facades\Mail;

class FrontController extends Controller
{
    public function email(Request $request)
    {
        $data = $request->all();

        try {
            Mail::to('jcuadros@meltec.com.co')->send(new FormularioContacto($data));
            return response()->json([
                'success' => true,
                'message' => 'Correo Enviado exitosamente',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
