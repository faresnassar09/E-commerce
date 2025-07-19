<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seller\Profile;
use App\Models\Seller\Seller;
use App\Services\FileServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Notifications\SellerNotify;
use App\Models\Product\Product;
use Faker\Guesser\Name;
class ProfileController extends Controller
{


public function __construct(public FileServices $fileService)
{
    
}
    public $image = null;
    public $folder = 'seller_profile_picture';
    public $guard = 'seller';


    
    public function index()
    {

        $userName = Auth::guard($this->guard)->user()->name;

        return view('sellers.profile',compact(

            'userName',
        ));


    }


    public function update(Profile $request, )
    {


      
        
$this->CheckEditAbilite($request);

if($request->hasFile('image')){

    $this->image = $request->image;
 


    $this->fileService->delete_Image($this->guard);


    $this->fileService->Upload_Image($this->image,$this->folder,$this->guard);


}


return back()->with('success','تم تحديث البيانات');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {

        
}



protected function CheckEditAbilite($request){

    $seller = Seller::find(Auth::guard('seller')->user()->id);

    
    if ($request->name != $seller->name && !is_null($request->name)) {
        $seller->name = $request->name;
    }
    
    $HashedPassword = Hash::make($request->password);

    if ($HashedPassword != $seller->password && !is_null($request->password)) {
        $seller->password = $HashedPassword;
    }
    

    $seller->save();
    

}

}