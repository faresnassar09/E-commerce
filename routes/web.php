<?php

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;



Route::get('lang/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'ar'])) {
        abort(400);
    }

    return back()->cookie(Cookie::forever('lang', $locale));

})->name('lang.switch');
 



