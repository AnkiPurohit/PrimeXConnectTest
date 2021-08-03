<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TestingRoutes
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
       // return $next($request);
        if (App::environment('production')) abort (404);
        
        return $next($request);
    }
}
