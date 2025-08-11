<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product\Product;
use App\Models\Store\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{

    public function index()
    {

        $user = Auth::user();
        $userAddress = $user?->addresses()->first();
        $products = null;
        $stores = null;

        if ($userAddress) {


                $products = Product::whereHas('store', function ($query) use ($userAddress) {
                $query?->where('street', $userAddress?->street ?? null)
                    ->orWhere('area_id', $userAddress?->area_id ?? null)
                    ->orWhere('city_id', $userAddress?->city_id ?? null);
            })
                ->orderByRaw("
                        CASE
                            WHEN store_id IN (SELECT id FROM stores WHERE street = ?) THEN 1
                            WHEN store_id IN (SELECT id FROM stores WHERE area_id = ?) THEN 2
                            WHEN store_id IN (SELECT id FROM stores WHERE city_id = ?) THEN 3
                            ELSE 4
                        END
                    ", [
                    $userAddress?->street,
                    $userAddress?->area_id,
                    $userAddress?->city_id,
                ])
                ->paginate(3);


            $stores = Cache::remember("user_stores_id{$user->id}.home_page",now()->addMinutes(10),function() use ($userAddress){

               return Store::with('images')
                ->where('street', $userAddress?->street)
                ->orWhere('area_id', $userAddress?->area_id)
                ->orWhere('city_id', $userAddress?->city_id)
                ->limit(4)
                ->get();

            });
        } 

if(!$products||!$user ){
    
             $products = Product::paginate(4);
            $stores = Store::limit(4)->get();  
    
}

        return view('index', compact('products', 'stores'));

    }
    public function dashboard()
    {

        $user = Auth::user();

        $data = [

            'currentOrders' => $user->orders->where('status', 0)->count(),
            'compleatedOrders' => $user->orders->where('status', 1)->count(),
            'canceledOrders' => $user->orders->where('status', 2)->count(),
            'returnedOrders' => $user->orders->where('status', 5)->count(),
            'totalPaid' => $user->orders->where('status', 1)->sum('price'),
            'items' => $user->orders()->where('status', 1)->with('items')->count(),

        ];

        return view('users.dashboard', compact('data'));
    }

    public function createNewAddresss()
    {

        return view('users.create-address');
    }

    public function storeNewAddress(Request $request)
    {

        Auth::user()->addresses()->create([

            'street' => $request->street,
            'city_id' => $request->city_id,
            'area_id' => $request->area_id,


        ]);

        return to_route('user.cart.index');
    }
}
