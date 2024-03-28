<?php

namespace App\Http\Middleware;

use App\Support\Google2FAAuthenticator;
use Closure;
use Session;
use Auth;
use DB;

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
        
        if(Auth::user()->tfa == 1){
            $expire = DB::table('users')->where('id', Auth::user()->id)->first();
            if($expire->tfa_expire == 1){
                return $next($request);
            }
            else{
                return redirect('/logout');
            }
        }
        return $next($request);
    }
}
