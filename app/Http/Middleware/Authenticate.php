<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {

        if (auth()->check() && !auth()->user()->two_factor_verified) {
            return redirect()->route('two-factor.index');
        }

    
        return $request->expectsJson() ? null : route('login');
    }
}
