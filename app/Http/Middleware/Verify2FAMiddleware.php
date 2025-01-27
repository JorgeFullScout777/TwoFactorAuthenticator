<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Verify2FAMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Verifica si el usuario está autenticado y si la sesion del usuario no tiene la clave 'two_factor_authenticated'
        // si no la tiene significa que no paso el segundo factor de autentificacion
        if (auth()->check() && !session('two_factor_authenticated')) {
            // Retorna a la pantalla de segundo factor de autenficacion
            return redirect()->route('two-factor.index');
        }
        return $next($request);
    }
}
