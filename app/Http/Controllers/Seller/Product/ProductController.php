<?php

namespace App\Http\Controllers\Seller\Product;

use App\Enums\CacheKeys;
use App\Facades\AuthSeller;
use App\Http\Controllers\Controller;
use App\Http\Requests\Products\ProductRequest;
use App\Models\Product\Product;
use App\Models\Product\ProductImage;
use App\Services\FileServices;
use App\Services\Seller\LoggingService;
use App\Services\Seller\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{

    public function __construct(

        public FileServices $fileServices,
        public ProductService $productService,
        public LoggingService $loggingService,

    ) {}

    public function index()

    {

        $products = $this->productService->getProducts();

        return view('sellers.products.index', compact('products'));
    }

    public function create()
    {

        $stores = $this->productService->getStores();

        $categories = $this->productService->getCategories();

        return view('sellers.products.create', compact('stores','categories'));
    }

    public function store(ProductRequest $request)
    {

        try {

             $store = $this->productService->findStore($request->store_id);

            if (!$store) {

                $this->loggingService->failed('Store is not found',[

                    'store_id' => $request->store_id
                ]);

                return $this->productService->storeNotFound();
            }

            if ($request->hasFile('images')) {

                $product  = $this->productService->createProduct($request);

                $this->loggingService->success('Product created successfully',[

                    'product_id' => $product->id,
                ]);
 
                $images =  $this->fileServices->uploadMultipleImages(

                    $request->file('images'),
                    'products_images'
                );

                if (!$images) {

                    return back()->with('failed',__('notifications.store_product_failed'));
                }

            // insert images paths in database

                $this->productService->insertImages($product, $images);

                return back()->with('success',__('notifications.store_product_succeeded'));
            }

        } catch (\Exception $e) {

            $this->loggingService->failed('Error occurred while  creating product',[

                'exception_details' => $e->getMessage(),
            ]);

        }
    }

    public function update(Product $product,Request $request)
    {

        try {
            
            Gate::forUser(AuthSeller::fullInfo())->authorize('update',$product);
    
            if ($request->hasFile('images')) {
                $images = $this->fileServices->uploadMultipleImages(
                    $request->file('images'),
                    'products_images'
                );

            $this->productService->insertImages($product, $images);
  
            }
    
    
            $this->productService->updateProduct($product,$request);

            $this->loggingService->success('Product updated successfully',[

                'product_id' => $product->id,
            ]);

            return back()->with('success', __('notifications.product_updated_successfully'));
        
        } catch (\Exception $e) {
    
            $this->loggingService->failed('Error occurred while updating product',[

                'product_id' => $product->id,
                'exception_details' => $e->getMessage(),
            ]);
    
            return back()->with('failed', __('notifications.product_update_failed'));
        }
    }
    
    public function destroy(Product $product){

        try {
            
            Gate::forUser(AuthSeller::fullInfo())->authorize('delete',$product);
            $productImages = null;
    
    
            $productImages = $product->images()->get();
    
    
            if ($productImages) {
    
                $this->fileServices->deleteMultiImages($productImages);
            }
    
            $this->productService->destroyProduct($product);
    
            $this->loggingService->success('Product deleted successfully',[

                'product_name' => $product->name,
            ]);

            return back()->with('success', __('notifications.product_deleted_successfully'));

        } catch (\Exception $e) {
    
            $this->loggingService->failed('Error occurred while deleting product',[

                'product_id' => $product->id,
                'exception_details' => $e->getMessage(),
            ]);

            return back()->with('failed', __('notifications.product_delete_failed'));
        }

    }

    public function deleteImage(ProductImage $image)
    {

        try {

            $this->fileServices->deleteImage($image->path);

            $this->productService->deleteImageFromDatabase($image);

            $this->loggingService->success('Product image deleted successfully',[

                'product_name' => $image->product_id,
            ]);

            return to_route('seller.product.index')->with('success',__('notifications.product_image_deleted_successfully'));

        } catch (\Exception $e) {

            $this->loggingService->failed('Product image not found',[

                'image_id' => $image->id,
                'exception_details' => $e->getMessage(),
            ]);

            return to_route('seller.product.index')->with('failed',__('notifications.product_image_delete_failed'));
        }
    }
}
