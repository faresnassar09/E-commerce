<?php

namespace App\Services;

use App\Models\Seller\Seller;
use App\Notifications\SellerOrderPlaced;
use Illuminate\Auth\AuthManager;
use Illuminate\Log\LogManager;
use Illuminate\Notifications\ChannelManager;


class AuthSeller
{

    public $seller = null;


  public function __construct()
  {

$this->seller = app(AuthManager::class)->guard('seller')->user();

}

public function fullInfo(){

    return $this->seller;
}


    public function check(): bool
    {
        return $this->seller !== null;
    }

    public function id(){

        return $this->seller?->id;
         
     }

    public function name()
    {

        return $this->seller?->name ;
    }

    public function email(){

        return $this->seller?->email;
    }


    public function notActive(){

        return $this->seller->status === 0 ;

    }
    public function active(){

        return $this->seller->status === 1 ;

    }

    public function sendOrderNotifications($sellerId,$title,$content){

$seller = Seller::find($sellerId);

 if(!$seller){return;}


        try {

          $status =  app(ChannelManager::class)
        ->send($seller,new SellerOrderPlaced($title,$content));

            return $status;

        } catch (\Exception $e) {
             

            app(LogManager::class)->channel('seller')->info('failed to record notification',[

                'seller_id' => $seller->id,
                'content ' => $content,
                'error' => $e->getMessage(), 

            ]);
            
        }

    }

    public function deleteCache($key) {

    app('cache')->forget($key);
          
    }


}
