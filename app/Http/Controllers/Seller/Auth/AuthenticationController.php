<?php

namespace App\Http\Controllers\Seller\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\UploadImages;
use App\Traits\Auth_Errors;

class AuthenticationController extends Controller
{
  use Auth_Errors;


    public function login(){


return view("sellers.auth.login");

    }


public function LoginAuthentication(request $request){

$validation = $request->validate([

'email' => ['required','max:100','email'],
'password' => ['required','min:8','max:32']

]);

if(Auth::guard('seller')->attempt($validation)){

    $request->session()->regenerate();


    return redirect()->route('seller.dashboard');

}else{

   $notify = Auth_Errors::Login_error($request->email);


   return back()->with('error_type',$notify);

}

}



    public function destroy(request $request){

        auth()->guard('seller')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return to_route('auth.seller.login');

    }

}
