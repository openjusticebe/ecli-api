<?php

namespace App\Http\Middleware;

use Closure;

class ApiAuthorize
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->bearerToken() == env('API_KEY')) {
            return $next($request);
        }
        return response('Unauthorized.', 401);
    }
}
