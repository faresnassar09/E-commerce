<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class SetLanguage
{

    public function handle(Request $request, Closure $next): Response
    {

        if (Cookie::has('lang')) {
            $lang = Cookie::get('lang');

            if (in_array($lang, ['en', 'ar'])) {
                App::setLocale($lang);
            }
        }

        return $next($request);
    }
}
