<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {    

    // Depuración: Ver el valor original de g-recaptcha-response

    // Limpiar el valor de g-recaptcha-response
    $recaptchaResponse = trim($request->input('g-recaptcha-response'));

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'g-recaptcha-response' => 'required',
        ]);

    // Verificar reCAPTCHA
    $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
        'secret' => config('services.recaptcha.secret_key'),
        'response' => $recaptchaResponse,
        'remoteip' => $request->ip(),
    ]);

        $responseData = $response->json();

        if (!$responseData['success']) {
            return redirect()->back()->withErrors(['g-recaptcha-response' => 'Por favor, verifica que no eres un robot.']);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => [
                'required', 
                'confirmed', 
                Rules\Password::defaults()
                    ->min(12) // Longitud mínima de 12 caracteres
                    ->letters() // Debe contener al menos una letra
                    ->mixedCase() // Debe contener al menos una mayúscula y una minúscula
                    ->numbers() // Debe contener al menos un número
                    ->symbols() // Debe contener al menos un carácter especial
            ],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        //Auth::login($user);

        return redirect(RouteServiceProvider::INDEX);
    }
}
