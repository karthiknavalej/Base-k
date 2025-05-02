<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;

class IsBusiness
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
        $roles = auth()->user()->roles()->get()->pluck('name')->toArray();
        if (!in_array('business', $roles)) {
            throw new AuthorizationException();
        }
        return $next($request);
    }
}
