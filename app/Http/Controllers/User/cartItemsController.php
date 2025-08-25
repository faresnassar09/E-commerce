<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class cartItemsController extends Controller
{


public function index(){

$CartItems = Auth::user()->cartItems()->with('product.images')->get();

return view('users.cart-items.index',compact('CartItems'));

}



public function getUserAdresses(){

    return  Auth::user()->adresses()->with('city','area')->get();  
   
       } 
    
}
