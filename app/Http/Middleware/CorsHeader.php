<?php

namespace App\Http\Middleware;

use Closure;

class CorsHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $response = $next($request);

        $response->headers->set('Access-Control-Allow-Origin', env('APP_DOMAIN'));
        $response->headers->set('Access-Control-Allow-Methods', 'HEAD, GET, POST, OPTIONS, PUT, PATCH, DELETE');
        $response->headers->set('Access-Control-Allow-Headers', 'Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type,Accept,Authorization');
        $response->headers->set('Access-Control-Expose-Headers', 'Date,Etag,Content-Type,Authorization,X-RateLimit-Limit,X-RateLimit-Remaining,X-RateLimit-Reset');

        return $response;
    }
}
