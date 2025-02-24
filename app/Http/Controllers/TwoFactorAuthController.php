<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Providers\TwoFactorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TwoFactorAuthController extends Controller
{
    protected $twoFactorService;
    
    public function __construct(TwoFactorService $twoFactorService)
    {
        $this->twoFactorService = $twoFactorService;
    }
    
    /*
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
    */

    public function index()
    {
        /*
        // Trae al usuario de la bd
        $user = auth()->user();
        // Crea el codigo
        $code = rand(100000, 999999);
        // Asigna el codigo y la fecha de expiración al usuario
        $user->two_factor_code = $code;
        //$user->two_factor_expires_at = now()->addMinutes(3);
        $user->two_factor_expires_at = now()->addSeconds(30);
        $user->save();
        // Envia el codigo al mail del usuario
        Mail::raw("Tu codigo de autenticacion es: $code", function ($message) use ($user) {
            $message->to($user->email)->subject('Two-Factor Code');
        });
        */
        // Retorna la vista de autenticacion
        return view('auth.two-factor-auth');
    }
    
    
    public function verify(Request $request)
    {
        // Valida que el codigo sea recibido y que sea numero entero
        $request->validate([
        'code' => 'required|integer',
        ]);
        // Trae al usuario de la bd
        $user = User::where('two_factor_code', $request->code)->first();
        // Valida que el codigo recibido sea el mismo de la bd
        //if ($user->two_factor_code == $request->code && now()->lt($user->two_factor_expires_at)) {
        if ($user) {
            $user->two_factor_code = null;
            $user->two_factor_verified = true;
            $user->two_factor_expires_at = null;
            $user->save();

            auth()->login($user);
    
            return redirect()->intended('/dashboard');
        }
        // Retorna a la pantalla de segundo factor de autentificacion en caso de que el codigo ingresado sea incorrecto
        return redirect()->route('two-factor.index')->withErrors(['code' => 'El codigo ingresado es invalido.']);
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
    
        // Verifica si el código ha expirado
        if ($user->two_factor_expires_at->lt(now())) {
            return back()->withErrors(['code' => 'El código de autenticación ha expirado.']);
        }
    
        // Valida que el codigo recibido sea el mismo de la bd
        if ($request->code == $user->two_factor_code) {
            // Establece la variable 'two_factor_authenticated'
            session(['two_factor_authenticated' => true]);
    
            // Obtener los permisos del usuario (asumiendo que tienes una relación 'permissions' en el modelo User)
            $permissions = $user->permissions->pluck('name')->toArray();
    
            // Redirigir al usuario a la página deseada
            return redirect()->intended('/home');
        }
    
        return back()->withErrors(['code' => 'El código de autenticación es incorrecto.']);
    }
    */

    public function resend(){

        $this->twoFactorService->generateAndSendCode();

        return response()->json(['message' => 'El código ha sido reenviado']);
    }

}