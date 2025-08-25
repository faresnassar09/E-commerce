<?php

namespace App\Http\Middleware;

use App\Facades\AuthSeller;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {


        if(!AuthSeller::fullInfo()){

return to_route('auth.seller.login');

        }elseif(AuthSeller::fullInfo()?->subscribed()){

            return to_route('seller.subscription.get_details');
        }


        return $next($request);
    }
}
