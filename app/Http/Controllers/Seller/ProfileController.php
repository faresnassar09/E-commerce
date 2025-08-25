<?php

namespace App\Http\Controllers\Seller;

use App\Facades\AuthSeller;
use App\Http\Controllers\Controller;
use App\Http\Requests\Seller\ProfileRequest;
use App\Services\FileServices;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{


public function __construct(public FileServices $fileService){}
   
    public function index()
    {

        $sellerName = AuthSeller::name();

        return view('sellers.profile',compact(

            'sellerName',
        ));

    }

    public function update(ProfileRequest $request )
    {


if($request->hasFile('image')){

    if (AuthSeller::fullInfo()->profile_picture) {

           $this->fileService->deleteImage(AuthSeller::fullInfo()->profile_picture);

    }

    $image = $this->fileService->uploadImage($request->image,'seller_avatars');

}

$this->CheckEditAbilite($request,$image);

return back()->with('success','تم تحديث البيانات');
}

protected function CheckEditAbilite($data,$image){

    $seller = AuthSeller::fullInfo();

    $seller->fill(['name'=>$data->name,'profile_picture' => $image]);

    if ($data->filled('password')) {

        $seller->fill(['password' => Hash::make($data->password)]) ;

    }

    if($seller->isDirty()){

        $seller->save();

    }

}

}