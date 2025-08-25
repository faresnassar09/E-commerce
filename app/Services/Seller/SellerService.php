<?php
namespace App\Services\Seller;
use App\Facades\AuthSeller;
use App\Models\Seller\Seller;
use Illuminate\Support\Facades\Hash;


class SellerService{



    public function createSeller($request)  {

       return Seller::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_numbers' => $request->phone_numbers,
            'password' => Hash::make($request->password),

        ]);
        
    }

    public function inserSellerAvatar($path){

        AuthSeller::fullInfo()->update([

            'profile_picture' => $path,
        ]);

    }


}