<?php

namespace App\Services\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class LoggingService {

public function success($message,array $data) {

    $this->log('info',$message,$data);
    
}


public function failed($message,array $data) {

$this->log('error',$message,$data);
    
}

public function warning($message,array $data) {

    $this->log('warning',$message,$data);
        
    }

private function log($logType,$message,array $data) {

    $data = [

    'user_id'     =>  Auth::id(),
    'user_ip'     =>  request()->ip(),
    'user_agent'  =>  request()->userAgent(),
    'url'           =>  request()->fullUrl(),
    'method'        =>  request()->method(),

    ] + $data;

    Log::channel('user')->$logType($message,$data);
    
}
}