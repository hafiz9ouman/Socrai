<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Log;

class RedirectMiddleware
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
   //      if(Auth::user()->soft_delete == 1){
   //          return redirect('/logout');
   //      }
   //      if (session('role') != 'admin') {

			// if (Auth::check() && Auth::user()->user_role == 0) {
			// 	return redirect ('/');
			// }
   //      }

// echo Auth::user()->user_role;
// dd(session()->all());


        // if (session('role') == 'admin') {
            if (Auth::check() && Auth::user()->user_role == 1) {

               Log::info( " redirect middleware hit ......  " );

                // return redirect ('/2fa');

                //Log::info("------------00------");
            }
        // }


        return $next($request);
    }
}
