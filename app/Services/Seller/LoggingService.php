<?php

namespace App\Services\Seller;

use App\Facades\AuthSeller;
use Illuminate\Support\Facades\Log;


class LoggingService {

public function success($message,array $data) {

    $this->log('info',$message,$data);
    
}


public function failed($message,array $data) {

$this->log('error',$message,$data);
    
}


private function log($logType,$message,array $data) {

    $data = [

    'seller_id' => AuthSeller::id(),
    'seller_ip' => request()->ip(),
    'seller_agent' => request()->userAgent(),
    'url'           => request()->fullUrl(),
    'method'        => request()->method(),

    ] + $data;

    Log::channel('seller')->$logType($message,$data);
    
}
}