<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Localization
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
        // Set fallback language
        $locale = 'en';

        // Check and get header has x-localization
        if ($request->hasHeader('x-localization')) {
            $locale = $request->header('x-localization');
        }

        // Check and get request has locale
        if ($request->filled('locale')) {
            $locale = $request['locale'];
        }

        // Set localization
        app()->setLocale($locale);

        return $next($request);
    }
}
