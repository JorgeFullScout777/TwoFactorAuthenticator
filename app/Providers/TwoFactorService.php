<?php
namespace App\Providers;

use Illuminate\Support\Facades\Mail;

class TwoFactorService
{
    public function generateAndSendCode()
    {
        // Cambia el tiempo de expiración del codigo
        $minutes = 3;
        // Trae al usuario de la bd
        $user = auth()->user();
        // Crea el codigo
        $code = rand(100000, 999999);
        // Asigna el codigo y la fecha de expiración al usuario
        $user->two_factor_code = $code;
        $user->two_factor_expires_at = now()->addMinutes($minutes);
        $user->save();
        // Envia el codigo al mail del usuario
        Mail::raw("Tu codigo de autenticacion es: $code \nExpirara en $minutes minutos", function ($message) use ($user) {
            $message->to($user->email)->subject('Two-Factor Code');
        });
    }
}