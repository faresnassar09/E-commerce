<?php

namespace app\Helpers;

use Illuminate\Support\Facades\Auth;

class Seller{


function name(){

   if(! Auth::guard('seller')->user() ){


   return 'لم تقم بتسجيل الدخول بعد';
        
   }

   return  Auth::guard('seller')->user()->id;


}

function njh(){

return  3 ;

}  

}
