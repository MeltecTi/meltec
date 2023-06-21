<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;

class AppExternal
{
   public function handle(Request $request, Closure $next)
   {
      if (!$request->wantsJson()) {
         return response()->json(['error' => 'Solicitud HTTP no valida'], 400);
      } else if (!$request->header('Accept') === 'application/json') {
         return response()->json(['error' => 'El encabezado requerido no se encuentra en la solicitud.'], 400);
      } else if(!$request->header('X-CLIENT-ID')) {
         return response()->json(['error' => 'Parametro de Solicitud No encontrado'], 400);
      } else if($request->header('X-CLIENT-ID') == null) {
         return response()->json(['error' => 'Parametro de Solicitud No valido'], 400);
      } 

      return $next($request);
   }
}
