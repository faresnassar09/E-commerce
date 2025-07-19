<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{


    
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            // إعادة التوجيه بناءً على الحارس
            if ($request->routeIs('auth.seller.*') || $request->routeIs('seller.*')) {
                return route('auth.seller.login');
            } elseif ($request->routeIs('admin.*')) {
                return route('admin.login');
            }
    
            return route('login'); // صفحة تسجيل الدخول الافتراضية
        }
    }
    
}
