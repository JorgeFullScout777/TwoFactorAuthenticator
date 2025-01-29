<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TwoFactorCodeController extends Controller
{
    /*
    protected $twoFactorService;
    
    public function __construct(TwoFactorCodeController $twoFactorService)
    {
        $this->twoFactorService = $twoFactorService;
    }
    public function __invoke(Request $request)
    {
        $user = auth()->user();
        $this->twoFactorService->generateAndSendCode($user);
        return back()->with('status', 'verification-link-sent');
    }
    */
}
