<?php
// this middleware is used to add a header to the request so we can differentiate between api and web
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnforceJson
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
        // Check if the request is for the API routes
        if ($request->is('api/*')) {
            // Force the 'Accept' header to 'application/json'
            $request->headers->set('Accept', 'application/json');
        }
        return $next($request);
    }
}
