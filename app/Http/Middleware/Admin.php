<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;

class Admin
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
        if (in_array(request()->getUri(), [
            route(
                'register',
                ['role' => 'admin']
            ),
            route(
                'register',
                ['role' => 'staff']
            ), route('login')
        ])) {
            return $next($request);
        }

        if (auth('sanctum')->user() == null) {
            return response(['message' => 'Unauthenticated'], 401);
        }

        if (auth('sanctum')->user()->role == "admin") {
            return $next($request);
        }
    }
}
