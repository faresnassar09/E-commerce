<?php
 
namespace App\Http\Controllers\Seller\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\Stores\EditStore;
use App\Http\Requests\Stores\StoreRequest;
use App\Models\store\Store;
use App\Facades\AuthSeller;
use App\Services\FileServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StoreController extends Controller
{
 
    public  $sellerId ;

    public function __construct(public FileServices $fileServices) {

        $this->middleware(function ($request, $next) {
            $this->sellerId = AuthSeller::id();
            return $next($request);
        });





    }

    public function index()
    {


        $seller = AuthSeller::fullInfo();
        $title = 'المتاجر';
        $stores = $seller->stores()->with('Images', 'city', 'area')->get();

        return view('sellers.stores.operations.index', compact('stores', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'انشاء متجر';

        return view('sellers.stores.operations.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(StoreRequest $request)
    {

        $seller = AuthSeller::fullInfo();

        $store = $this->insertStore($request, $seller);

        if ($request->hasFile('images')) {


            $this->uploadImages($request->images, $store->id);
        }

        return back()->with('success', 'تم اضافة المتجر بنجاح');
    }

    public function edit($storeId)
    {
        return $this->editStore($storeId);
    }


    public function update(EditStore $request, $storeId)
    {

        $store = $this->findStore($storeId);


        if (!$store) {

            return $this->storeNotFound();
        }

        $this->updateStore($request , $store);


        return back()->with('success', 'تم التعديل بنجاح');
    }


    public function destroy($storeId)
    {



        $store = $this->findStore($storeId);

        if (!$store) {

            return $this->storeNotFound();
        }
try {


        $store->delete();

        Log::channel('seller')->info(' trying to delete :: store has been deleted', [

            'seller_id' => $this->sellerId,
            'store_info' => $store,
        ]);

        return back()->with('success', 'تم حذف المتجر');

} catch (\Exception $e) {

    Log::channel('seller')->info(' trying to delete :: store has been deleted', [

        'store_info' => $store,
        'exception_details' => $e->getMessage(),
    ]);
}


    }


    private function insertStore($request, $seller)
    {

        try {

            $store = $seller->stores()->create([

                'name' => $request->name,
                'description' => $request->description,
                'city_id' => $request->address['city_id'],
                'area_id' => $request->address['area_id'],
                'street' => $request->address['street'] ?? null,
                
            ]);
             


            Log::channel('seller')->info('store has been created', [

                'seller_id' => AuthSeller::id(),
                'store_id' => $store?->id ,

            ]); 
            
            return $store;
              
        } catch (\Illuminate\Database\QueryException $e) {

            Log::channel('seller')->error('store has been not created', [

                'seller_id' => $this->sellerId,
                'exception_details' => $e->getMessage(),

            ]);
        }


    }

    private function uploadImages($images, $storeId)
    {
        try {


            $Status = $this->fileServices->uploadMultipleImages(
                $table = 'store_images',
                $foreginId = 'store_id',
                $storeId = $storeId,
                $images = $images,
                $folder = 'store_images',
            );

            Log::channel('seller')->info('images have been uploaded successfully', [

                'user_id' => $this->sellerId,
                'table' =>  $table,
                'foreginId' => $foreginId,
                'store_id' => $storeId,
                'folder' => $folder,


            ]);
        } catch (\Exception $e) {

            Log::channel('seller')->error('An error occurred while uploading images', [

                'user_id' => $this->sellerId,
                'exception_details' => $e->getMessage(),
                'table' =>  $table,
                'foreginId' => $foreginId,
                'store_id' => $storeId,
                'folder' => $folder,


            ]);
        }
    }



    private function editStore($storeId)
    {


        $store = $this->findStore($storeId);


        if (!$store) {

            Log::channel('seller')->error('store not found', [

                'user_id' => $this->sellerId,
                'store_id' => $storeId,
            ]);

            return back()->with('failed', 'المتجر غير موجود');
        } else {

            $title = 'تعديل المتجر' . $store->name;

            return view('sellers.stores.operations.edit', compact('store', 'title'));
        }
    }

    private function updateStore($request , $store)
    {

        $store->name = $request->name;
        $store->description = $request->description;
        $store->city_id = $request->address['city_id'] ?? $store->city_id;
        $store->area_id = $request->address['area_id'] ?? $store->area_id;
        $store->street = $request->address['street']   ?? $store->street;

        $store->save();

        Log::channel('seller')->info('store has been updated', [

            'seller_id' => $this->sellerId,
            'store_id' => $store->id,
        ]);
    }

    private function findStore($storeId)
    {

        return AuthSeller::fullInfo()->stores()->find($storeId);
    }

    private function storeNotFound()
    {

        Log::channel('seller')->error('store not found', [

            'seller_id' => $this->sellerId,
            'store_id' => request('store_id'),
        ]);
        return redirect()->back()->with('failed', 'لقد حدث خطاء حاول مرة اخري');
    }
}
