<?php

namespace App\Services\Seller;

use App\Enums\CacheKeys;
use App\Facades\AuthSeller;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;


class ProductService
{

    public function __construct(public CacheService $cacheService){}

    public function getProducts()
    {

        return $this->cacheService->getcachedProducts();

    }

    public function createProduct($data)
    {

        return   AuthSeller::fullInfo()->products()->create([

            'name'                  =>   $data->name,
            'description'           =>   $data->description,
            'price'                 =>   $data->price,
            'available_quantity'    =>   $data->quantity,
            'discount'              =>   $data->discount ?? 0,
            'store_id'              =>   $data->store_id,
            'category_id'           =>   $data->category_id,

        ]);
    }

    public function updateProduct($product, $data)
    {

        $product->fill($data->all());

        if ($product->isDirty()) {

            $product->save();
        }
    }

    public function destroyProduct($product)
    {

        $product->delete();
    }

    public function productNotFound()
    {
        return back()->with('failed', 'المنتج غير موجود');
    }


    public function increaseProductQuantity($product, $quantity)
    {

        return $product->increment('available_quantity', $quantity);
    }
    public function decreaseProductQuantity($product, $quantity)
    {

        return   $product->decrement('available_quantity', $quantity);
    }

    public function resetProductQuantity($product) {

        $this->decreaseProductQuantity($product,$product->available_quantity);

    }

    public function getStores()
    {


        return AuthSeller::fullInfo()->stores()->select('name', 'id')->get();
    }

    public function getCategories()
    {

        return Cache::remember("categories", now()->addDay(7), function () {

            return Category::all();
        });
    }

    public function findStore($storeId)
    {

        return  AuthSeller::fullInfo()->stores()->find($storeId);
    }

    public function storeNotFound()
    {

        return back()->with('failed', 'المتجر غير موجود');
    }


    public function insertImages($product, $imagesPaths)
    {


        foreach ($imagesPaths as $imagePath) {

            $product->images()->create([

                'path' => $imagePath,
            ]);
        }
    }

    public function  deleteImageFromDatabase($image) {

        $image->delete();

    }
}
