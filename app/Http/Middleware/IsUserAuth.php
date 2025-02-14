<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsUserAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

     public function handle(Request $request, Closure $next): Response
     {
         // Verificar si el usuario está autenticado y si tiene el rol 'user'
         $user = auth('api')->user();

         if (!$user) {
             return response()->json(['message' => 'No autorizado'], 401);
         }

         // Si el usuario no tiene el rol 'user', lo redirige
         if ($user->role !== 'user' && $user->role !== 'admin') {
             return response()->json(['message' => 'No autorizado'], 403);  // 403 Forbidden
         }

         return $next($request);  // Continuar con la solicitud si el rol es 'user'
     }
 }




//     public function handle(Request $request, Closure $next): Response
//     {
//         if(auth('api')->user()) {
//             return $next($request);
//         }else{
//             return response()->json(['message' => 'No autorizado'], 401);
//         }
//     }
// }
