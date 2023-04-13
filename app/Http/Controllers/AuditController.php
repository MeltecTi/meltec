<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;
use Illuminate\Support\Facades\Auth;

class AuditController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if(!$user->isAdmin()) {
            abort(403, 'Acceso denegado');
        }

        $auditions = Audit::orderBy('created_at', 'desc')->get();

        $title = 'Auditoria';

        return view('auditory.index', compact('title', 'auditions'));
    }

    public function audition(Request $request, string $id)
    {
        $user = Auth::user();
        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        
        if($user->api_token !== $token) {
            abort(403, 'Acceso no autorizado');
        };

        $data = Audit::find($id);
        $userdata = $data->user->name;

        return response()->json([
            'message' => 'ok',
            'data' => $data,
            'userResponse' => $userdata,
        ]);
    }
}