<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetUserLocale
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
        $locales  = array_column(config('app.supported_locales'), 'short_code');
        $language = $request->getPreferredLanguage($locales);

        app()->setLocale($language);

        return $next($request);
    }
}
