<?php

namespace App\Jobs\Seller;

use App\Mail\Seller\OrderStatusUpdateMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendOrderStatusUpdateMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $sellerInfo ;
    public $orderDetails = [];
    public $user;
    public $page;
    
    public function __construct($sellerInfo,$orderDetails,$user,$page)
    {


        $this->sellerInfo = $sellerInfo;
        $this->orderDetails = $orderDetails;  
        $this->page = $page; 
        $this->user = $user;
  
    }




    public function handle(): void
    {

        try {


        Mail::to($this->sellerInfo['email'])->send(new OrderStatusUpdateMail(
                    
            $this->sellerInfo,
            $this->orderDetails,
            $this->user,
            $this->page,

        ));

       Log::channel('seller')->info('email sent successfully', [
        'seller_email' => $this->sellerInfo['email'] ?? null ,
        'order_id' => $this->orderDetails['id'] ?? null,     
    ]);
    } catch (\Exception $e) {
    Log::channel('seller')->error('Failed to send order placed email', [
        'seller_id' => $this->sellerDetail['email']  ?? null,
        'error' => $e->getMessage(),
    ]);
}

}
}