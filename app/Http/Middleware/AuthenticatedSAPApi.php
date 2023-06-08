<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticatedSAPApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        dd(auth()->user());
        $token = str_replace('Bearer: ', '', $request->header('Authorization'));
        
        if(!$request->user()) {
            return response()->json(['error' => 'Usuario No Autorizado'], 401);
        }
        
        $user = User::where('api_token', $token)->first();

        if(!$user) {
            return response()->json(['error' => 'Token de Authorizacion Invalido'], 401);
        }

        return $next($request);
    }
}
