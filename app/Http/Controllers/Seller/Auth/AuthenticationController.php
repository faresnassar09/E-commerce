<?php

namespace App\Http\Controllers\Seller\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seller\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{

    public function login(){

return view("sellers.auth.login");

    }


public function LoginAuthentication(LoginRequest $request){


if(Auth::guard('seller')->attempt($request->only(['email','password']))){

    $request->session()->regenerate();


    return to_route('seller.dashboard');

}

   return back()->with('failed',__('messages.uncorrect_email_or_password'));



}

    public function destroy(request $request){

        auth()->guard('seller')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return to_route('auth.seller.login');

    }

}
