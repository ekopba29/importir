<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;

class Staff
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
        if (in_array(request()->getPathInfo(), [
            route(
                'reg',
                ['role' => 'admin']
            ),
            route(
                'reg',
                ['role' => 'staff']
            ), route('login')
        ])) {
            return $next($request);
        }
        
        if (auth('sanctum')->user() == null) {
            return response(['message' => 'Unauthenticated'], 401);
        }

        if (in_array(auth('sanctum')->user()->role, ["staff", "admin"])) {
            return $next($request);
        }
    }
}
