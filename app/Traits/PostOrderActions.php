<?php
namespace App\Traits;

use App\Mail\OrderPlaced;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use queue;

Trait PostOrderActions{

      public  function sendUserOrderPlacedMail($userDetails,$orderDetails){



    }

    // public function sendSellerOrderPlacedMail($sellerName,$sellerEmail,$orderDetails){


    //     Mail::to($sellerEmail)->send(new OrderPlaced(
            
    //         $sellerName,
    //         $sellerEmail,
    //         $orderDetails,
    //         'seller-order-placed',
            
    //     ));


    }


