<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class LogoutMiddleware
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
        if(Auth::check())
        {
            if(Auth::user()->soft_delete==1)
            {
                Auth::logout();
                // return redirect('/'); 
                return redirect('/login'); 
            }
        }
        return $next($request);
    }
}
