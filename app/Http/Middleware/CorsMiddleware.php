<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $allowedDomains = ['dev.socrai.com'];

        $origin = $request->header('Origin');
        $parsedOrigin = parse_url($origin, PHP_URL_HOST);

        // $response = $next($request);
        // return $response;
        // dd($allowedDomains);

        if (in_array($parsedOrigin, $allowedDomains)) {

            $response = $next($request);

            $response->headers->set('Access-Control-Allow-Origin', $origin);
            $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');

            return $response;
        }

        // For preflight requests, return a 204 No Content response
        if ($request->isMethod('OPTIONS')) {
            return response('', 204);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
