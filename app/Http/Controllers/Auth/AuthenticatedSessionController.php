<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Providers\TwoFactorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    protected $twoFactorService;
    
    public function __construct(TwoFactorService $twoFactorService)
    {
        $this->twoFactorService = $twoFactorService;
    }
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {

        // Verificar reCAPTCHA
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        $responseData = $response->json();

        if (!$responseData['success']) {
            return redirect()->back()->withErrors(['g-recaptcha-response' => 'Por favor, verifica que no eres un robot.']);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->back()->withErrors(['password' => 'El correo y/o contraseña son incorrectos.']);
        }

        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->withErrors(['password' => 'El correo y/o contraseña son incorrectos.  ']);
        }
        //$request->authenticate();
        //$request->session()->regenerate();
        $this->twoFactorService->generateAndSendCode($request->email);
        return redirect()->route('two-factor.message');

        //return redirect()->intended(RouteServiceProvider::TF);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = auth()->user();
        $user->two_factor_verified = false;
        $user->save();

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
