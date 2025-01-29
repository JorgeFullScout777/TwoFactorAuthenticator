<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureTwoFactorVerified
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
        $user = Auth::user();

        // Verifica si el código de two-factor ha expirado
        if ($user->two_factor_expires_at && now()->gt($user->two_factor_expires_at)) {
            // Cierra la sesión del usuario
            Auth::logout();

            // Redirige al usuario a la página de inicio de sesión con un mensaje de error
            return redirect()->route('login')->withErrors([
                'two_factor' => 'El código de two-factor ha expirado. Por favor, inicia sesión nuevamente.',
            ]);
        }

        // Verifica si el usuario no ha completado el two-factor
        if (!$user->two_factor_verified) {
            return redirect()->route('two-factor.index');
        }

        return $next($request);
    }
}
