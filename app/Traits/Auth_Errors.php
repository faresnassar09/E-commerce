<?php

namespace App\Traits;


trait Auth_Errors {

public static function Login_Error($email){

$notify =' ';

if(\App\Models\Seller\Seller::where('email',$email)->exists()){

    $notify = 'الباسوورد خاطئ';
}else { $notify ='الايميل غير مسجل في النظام';}

return $notify;



}


}
