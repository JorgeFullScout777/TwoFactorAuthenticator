<?php
namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class TwoFactorService
{
    public function generateAndSendCode($email)
    {
        // Cambia el tiempo de expiración del código
        $minutes = 3;
        // Trae al usuario de la bd
        //$user = auth()->user();
        $user = User::where('email', $email)->first();
        // Crea el código
        $code = rand(100000, 999999);
        // Asigna el código y la fecha de expiración al usuario
        $user->two_factor_code = $code;
        $user->two_factor_expires_at = now()->addMinutes($minutes);
        $user->save();
    
        // Genera la URL firmada para la verificación del código
        $verificationUrl = URL::temporarySignedRoute(
            'two-factor.index',
            now()->addMinutes($minutes),
            ['user' => $user->id]
        );
    
        // Envía el código y la URL firmada al correo del usuario
        Mail::raw("Tu código de autenticación es: $code \nExpirará en $minutes minutos. \nHaz clic en el siguiente enlace para verificar tu código: $verificationUrl", function ($message) use ($user) {
            $message->to($user->email)->subject('Two-Factor Code');
        });
    }
}