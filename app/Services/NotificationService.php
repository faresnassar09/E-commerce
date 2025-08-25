<?php

namespace App\Services;

use App\Facades\AuthSeller;
use App\Models\Seller\Seller;
use App\Notifications\SellerOrderTracking;
use Illuminate\Support\Facades\Notification;

class NotificationService { 


public function  notifySellerOfOrderTracking(Seller $seller,$userName,$title,$content) {
    
      
Notification::send($seller,new SellerOrderTracking(

    $title,
    "قام العميل .$userName.$content"

));
        
      
    }


}