<?php 

namespace App\Services;
use App\Facades\AuthSeller;
use App\Jobs\Seller\SendOrderStatusUpdateMailJob as SellerJobMail;
use App\Jobs\User\SendOrderStatusUpdateMailJob as UserJobMail;
use Illuminate\Support\Facades\Cookie;

class EmailService{




    public function sendOrderUserTrakingMail($user, $orderDetails, $sellerPhone, $viewPage)
    {

        dispatch(new UserJobMail($user, $orderDetails, $sellerPhone, $viewPage));
    }

    public function sendOrderSellerTrakingMail($seller,$orderDetails,$orderEmailData,$viewPage)
    {

        dispatch(new SellerJobMail(

            $seller,
            $orderDetails,
            $orderEmailData,
            $viewPage
        ));

        
    }

}