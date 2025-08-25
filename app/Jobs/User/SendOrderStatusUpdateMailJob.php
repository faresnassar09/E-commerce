<?php

namespace App\Jobs\User;

use App\Mail\User\OrderStatusUpdateMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendOrderStatusUpdateMailJob implements ShouldQueue
{

    public $tries = 3;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $userInfo = [];
    public $orderDetails = [];
    public $sellerPhoneNumber ; 
    public $page ;

    public function __construct($userInfo , $orderDetails, $sellerPhoneNumber, $page)
    {


        $this->userInfo = $userInfo;
        $this->orderDetails = $orderDetails;
        $this->sellerPhoneNumber = $sellerPhoneNumber;
        $this->page = $page ; 
    }



    public function handle(): void
    {

        try {


            Mail::to($this->userInfo['email'])->send(new OrderStatusUpdateMail(

                $this->userInfo,
                $this->orderDetails,
                $this->sellerPhoneNumber,
                $this->page,

            ));


            Log::channel('user')->info('email sent successfully', [
                'user_email' =>$this->userInfo['email'] ?? null ,
                'order_id' => $this->orderDetails['id'] ?? null,
            ]);
        } catch (\Exception $e) {
            Log::channel('user')->error('Failed to send order placed email', [
                'user_email' => $this->userInfo['email'] ?? null,
                'error' => $e->getMessage(),
            ]);
        }


        // $this->sendSellerOrderPlacedMail($this->sellerName,$this->sellerEmail,$this->orderDetails);

    }
}
