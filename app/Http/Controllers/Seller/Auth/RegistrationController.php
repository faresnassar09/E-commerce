<?php

namespace App\Http\Controllers\Seller\Auth;

use App\Events\Mails\Send_Welcome_Message;
use App\Http\Controllers\Controller;
use App\Http\Requests\Seller\Store;
use App\Models\Seller\Seller;
use App\Services\FileServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;

class RegistrationController extends Controller
{


    public function __construct(public FileServices $fileServices)
    {
        
    }
    
    public $image = null;
    public $folder = 'seller_profile_picture';
    public $guard = 'seller';



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['message' => 'Account created successfully','data'=>'fares'], 201);

}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view("sellers/auth/register");
    }


    public function store(Store $request)
    {

        $seller = $this->insertSeller($request);
        
        $this->Login($seller);

if($request->hasFile('image')){

    $this->uploadProfileImage($request->image);

};

return to_route('seller.dashboard');

    }



    private function insertSeller($request){
    

        try {
            
            $seller = Seller::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_numbers' => $request->phone_numbers,
            'password' => Hash::make($request->password),

        ]);

        Log::channel('seller')->info('seller account created successfully',[

            'seller_id' => $seller->id,
            'ip_address' => $request->ip(),
        ]);

        return $seller;

        } catch (\Exception $e) {


            Log::channel('seller')->info('error occurred while creat seller account',[

                'name' => $request->name,
                'ip_address' => $request->ip(),
                'exception_details' => $e->getMessage(),
            ]);    
        
        }


    
    }

    private function Login($seller){


        auth()->guard($this->guard)->login($seller);
        session()->regenerate();

    }

    private function uploadProfileImage($profile_Image){

        $this->image = $profile_Image;
 
        //everything happens in Upload_Image add anything you want here

    $imagePath =  $this->fileServices->Upload_Image($this->image,$this->folder,$this->guard);



    }

}
