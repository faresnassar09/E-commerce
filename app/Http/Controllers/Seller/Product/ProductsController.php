<?php

namespace App\Http\Controllers\Seller\Product;

use App\Facades\AuthSeller;
use App\Http\Controllers\Controller;
use App\Http\Requests\Products\ProductRequest;
use App\Models\Category;
use App\Models\Product\Product;
use App\Models\Product\ProductImage;
use App\Services\FileServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{

    public function __construct(public FileServices $fileServices) {}

    public function index()

    {

        $seller = AuthSeller::fullInfo();
        $title = 'قائمة المنتجات';

        $products = $seller->products()->with('images')->paginate(12);

        return view('sellers.products.index', compact('products', 'title'));
    }


    public function create()
    {

        $stores = AuthSeller::fullInfo()->stores()->select('name', 'id')->get();

        $categories = Cache::remember("categories", now()->addDay(7), function () {

            return Category::all();
        });

        $title = 'انشاء منتج';

        return view('sellers.products.create', compact('stores', 'title', 'categories'));
    }


    public function store(ProductRequest $request)
    {

        $store = $this->findStore($request->store_id);

        if (!$store) {
            
            return $this->storeNotFound();
        }

        if ($request->hasFile('images')) {


            $product  = $this->insertProduct($request);

            $images =  $this->insertImages($request->images, $product->id);

            AuthSeller::deleteCache("seller_product_id".AuthSeller::id());

            if (!$images) {

                return back()->with('failed', 'حدث خطاء اثناء رفع الصور تاكد من ان حجم الصورة اقل من 2 ميجا');
            }

            

            return back()->with('success', 'تم اضافة المنتج بنجاح');
        }
    }



    public function update(Request $request, $productId)
    {

        $product = $this->findProduct($productId);


        if (!$product) {
            return $this->productNotFound();
        }

        if ($request->hasFile('images')) {

            $this->insertImages($request->images, $productId);
        }

        $product = $this->updateProduct($request, $productId);


        return back()->with('success', ' تمت العملية التعديل بنجاح ');
    }


    public function destroy(string $productId)

    {
        $product = $this->findProduct($productId);
        $productImages = null;

        if (!$product) {

            $this->productNotFound();
        }

        $productImages = $product->images()->get();


        if ($productImages) {

            FileServices::deleteMultiImages($productImages);
        }

        $product->delete();

        return back()->with('success', 'تم حذف المنتج بنجاح');
    }



    // Store Founctions

    public function findStore($storeId)
    {

        return  AuthSeller::fullInfo()->stores()->find($storeId);
    }

    public function storeNotFound()
    {
        Log::channel('seller')->error('the store is not found', [

            'user_id' => AuthSeller::id(),
            'store_id' => request('store_id'),
        ]);
        return back()->with('failed', 'المتجر غير موجود');
    }



    // Product Founctions


    public function insertProduct($data)
    {


        $product = new Product();

        $product->name                =   $data->name;
        $product->description         =   $data->description;
        $product->price               =   $data->price;
        $product->available_quantity  =   $data->quantity;
        $product->discount            =   $data->discount ?? 0;
        $product->seller_id           =   AuthSeller::id();
        $product->store_id            =   $data->store_id;
        $product->category_id         =   $data->category_id;

        $product->save();

        Log::channel('seller')->info('product created successfully', [

            'user_id' => AuthSeller::id(),
            'product_id' => $product->id,

        ]);

        return $product;
    }

    public function insertImages($images, $productId)
    {

        $images = $this->fileServices->uploadMultipleImages(

            $table = 'product_images',
            $foriegnId = 'product_id',
            $productId = $productId,
            $images,
            'product_images'
        );


        return $images;
    }

    // Products founctions

    public function findProduct($productId)
    {


        $product = AuthSeller::fullInfo()->products()->select(

            'id',
            'name',
            'discount',
            'description',
            'price',
            'available_quantity',

        )->find($productId);

        return $product;
    }

    public function productNotFound()
    {
        return back()->with('failed', 'المنتج غير موجود');

        Log::channel('seller')->info('product not found', [

            'user_id' => AuthSeller::id(),
            'product_id' => request('product_id'),

        ]);
    }

    public function updateProduct($data, $productId)
    {

        $product = Product::find($productId);

        $product->name                =   $data->name ?? $product->name;
        $product->description         =   $data->description ?? $product->description;
        $product->price               =   $data->price ?? $product->price;
        $product->available_quantity  =   $data->quantity ?? $product->available_quantity;
        $product->discount            =   $data->discount ?? $product->discount;

        $product->save();


        Log::channel('seller')->info('product updated successfully', [

            'user_id' => AuthSeller::id(),
            'product_id' => $product->id,

        ]);


        return $product;
    }





    // end poind to delete an product image (web api)


    public function deleteImage(Request $request, $id)
    {

        try {

            $image = ProductImage::find($id);


            Log::channel('seller')->info('image deleted successfully', [

                'user_id' => AuthSeller::id(),
                'image_id' => $image->id,

            ]);

            $originalPath = 'public/' . $image->path;


            Storage::delete($originalPath);
            $image->delete();

            return response()->json(['success' => true, 'message' => 'تم حذف الصورة بنجاح']);
        } catch (\Exception $e) {


            Log::channel('seller')->info('image not found', [

                'user_id' => AuthSeller::id(),
                'image_id' => $id,
                'error' => $e->getMessage(),

            ]);

            return response()->json(['success' => false, 'message' => 'الصورة غير موجودة!'], 404);
        }
    }
}
