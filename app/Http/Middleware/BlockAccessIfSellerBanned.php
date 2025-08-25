<?php

namespace App\Http\Middleware;

use App\Facades\AuthSeller;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlockAccessIfSellerBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if(AuthSeller::check() && AuthSeller::notActive()){

            return abort(403);


        }
        return $next($request);
    }
}
