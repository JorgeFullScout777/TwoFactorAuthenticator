<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TwoFactorAuthController extends Controller
{
    
    public function index()
    {
        // Trae al usuario de la bd
        $user = auth()->user();
        // Crea el codigo
        $code = rand (100000, 999999);
        // Asigna el codigo al usuario
        $user->two_factor_code = $code;
        $user->save();
        // Envia el codigo al mail del usuario
        Mail::raw("Tu codigo de autenticacion es: $code", function ($message) use ($user) {
        $message->to($user->email)->subject('Two-Factor Code');
        });
        // Retorna la vista de autenticacion
        return view('auth.two-factor-auth');
    }

    public function verify(Request $request){
        // Valida que el codigo sea recibido y que sea numero entero
        $request->validate([
            'code' => 'required|integer',
        ]);

        // Trae al usuario de la bd
        $user = auth()->user();

        // Valida que el codigo recibido sea el mismo de la bd
        if ($request->code == $user->two_factor_code) {
            // Establece la variable 'two_factor_authenticated'
            session(['two_factor_authenticated' => true]);

            // Obtener los permisos del usuario (asumiendo que tienes una relación 'permissions' en el modelo User)
            $permissions = $user->permissions->pluck('name')->toArray();

            // Crear una cookie con los permisos del usuario
            $permissionsCookie = cookie('user_permissions', json_encode($permissions), 120); // 120 minutos de duración

            // Redirigir al dashboard con la cookie adjunta
            return redirect()->intended('/dashboard')->withCookie($permissionsCookie);
        }

        // Retorna a la pantalla de segundo factor de autentificacion en caso de que el codigo ingresado sea incorrecto
        return redirect()->route('two-factor.index')->withErrors(['code' => 'El codigo ingresado es incorrecto.']);
    }
    
    /*
    public function verify(Request $request)
    {
        // Valida que el codigo sea recibido y que sea numero entero
        $request->validate([
        'code' => 'required|integer',
        ]);
        // Trae al usuario de la bd
        $user = auth()->user();
        // Valida que el codigo recibido sea el mismo de la bd
        if ($request->code == $user->two_factor_code) {
            // Establece la variable 'two_factor_authenticated'
            session(['two_factor_authenticated' => true]);
            return redirect()->intended ('/dashboard');
        }
        // Retorna a la pantalla de segundo factor de autentificacion en caso de que el codigo ingresado sea incorrecto
        return redirect()->route('two-factor.index')->withErrors(['code' => 'El codigo ingresado es incorrecto.']);
    }*/

}