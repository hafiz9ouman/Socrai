<?php

namespace App\Http\Middleware;

use App\Support\Google2FAAuthenticator;
use Closure;
use Session;

class LoginSecurityMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $ff = Session::get('google2fa');
        
        // dd($request);
        $authenticator = app(Google2FAAuthenticator::class)->boot($request);
       
         // dd($authenticator->isAuthenticated());
        if ($authenticator->isAuthenticated()) {
            // dd('yes');
            //  return $authenticator->makeRequestOneTimePasswordResponse();
            return $next($request);
        }
        // dd('no');

        return $authenticator->makeRequestOneTimePasswordResponse();
    }
}
