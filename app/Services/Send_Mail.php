<?php

namespace App\Services;
use Illuminate\Support\Facades\Mail;
use App\Mail\Send_Welcome_Message;

class Send_Mail {

public static function Wellcome_Message($to){


    Mail::to($to)->send(new Send_Welcome_Message());


}



}