<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SayCheeseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        dump('Hey, say cheese!');
        return $next($request);
    }

    // Note! Terminate will be called when response will be returned back. Terminate is the reverse of handle
    public function terminate($request, $response)
    {
        dump('Hey, say cheese from terminate!');
    }

}
