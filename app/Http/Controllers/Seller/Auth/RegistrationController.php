<?php

namespace App\Http\Controllers\Seller\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seller\Store;
use App\Services\FileServices;
use App\Services\Seller\SellerService;
use App\Facades\AuthSeller;
use App\Services\Seller\LoggingService;

class RegistrationController extends Controller
{


    public function __construct(
        
        public FileServices $fileServices,
        public SellerService $sellerService,
        public LoggingService $loggingService,

        ) {}
  
    public function create()
    {

        return view("sellers/auth/register");
    }


    public function store(Store $request)
    {


        try {

            $seller = $this->sellerService->createSeller($request);

            AuthSeller::makeUserAuthentcated($seller);
                    
        if ($request->hasFile('image')) {

            $sellerAvatarPath = $this->fileServices->uploadImage(

                $request->file('image'),
                'sellers_avatar'
            );

            if ($sellerAvatarPath) {
                $this->sellerService->inserSellerAvatar($sellerAvatarPath);

            }

        };

           $this->loggingService->success('seller account created successfully',[]);

            return to_route('seller.dashboard');

        } catch (\Exception $e) {


            $this->loggingService->failed('error occurred while create seller account', [

                'exception_details' => $e->getMessage(),
            ]);
        }
        
        return to_route('seller.dashboard');
    }

}
