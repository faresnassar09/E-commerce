<?php

namespace App\Http\Controllers\Seller\Product;

use App\Facades\AuthSeller;
use App\Http\Controllers\Controller;
use App\Http\Requests\Products\StatisticsRequest;
use App\Models\Product\Product;
use App\Services\Seller\LoggingService;
use App\Services\Seller\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class StatisticController extends Controller
{

    public function __construct(

        public ProductService $productService,
        public LoggingService $loggingService,
    ) {}

    public function index()
    {

        $products = $this->productService->getProducts();

        return view('sellers.products.statics.index', compact('products'));
    }

    public function  increaseQuantity(StatisticsRequest $request)
    {

        try {

            $product = Product::findOrFail($request->product_id);

            Gate::forUser(AuthSeller::fullInfo())->authorize('canIncrease', $product);

            $this->productService->increaseProductQuantity($product, $request->quantity);

            $this->loggingService->success('product quantity has been increased', [

                'product_id' => $product->id,
                'quantity' => $request->quantity,
            ]);

            return back()->with('success',__('notifications.product_quantity_increased_successfully') );

        } catch (\Exception $e) {

            $this->loggingService->failed('Unexpected error occurred while increase product quantity', [

                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'exception_error' => $e->getMessage(),

            ]);

            return back()->with('failed',__('notifications.product_quantity_increase_failed'));
        }
    }

    public function decreaseQuantity(StatisticsRequest $request)
    {

        try {


            $product = Product::findOrFail($request->product_id);

            Gate::forUser(AuthSeller::fullInfo())->authorize('canDecrease', $product);


            $status = $this->productService->decreaseProductQuantity($product, $request->quantity);

            if (!$status) {

                return back()->with('failed',);
            }

            $this->loggingService->success('product quantity has been decreased', [

                'product_id' => $product->id,
                'quantity' => $request->quantity,
            ]);

            return back()->with('success', __('notifications.product_quantity_decreased_successfully'));

        } catch (\Exception $e) {

            $this->loggingService->failed('Unexpected error occurred while descreasing product quantity', [

                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'exception_error' => $e->getMessage(),

            ]);

            return back()->with('failed',__('notifications.product_quantity_decrease_failed'));
        }
    }

    public function resetQuantity(Request $request)
    {

        try {

            $product = Product::findOrFail($request->product_id);

            Gate::forUser(AuthSeller::fullInfo())->authorize('canReset', $product);


            $this->productService->resetProductQuantity($product);

            $this->loggingService->success('product quantity has been reset', [

                'product_id' => $product->id,
                'quantity' => $request->quantity,
            ]);

            return back()->with('success', __('notifications.product_quantity_reseted_successfully'));

        } catch (\Exception $e) {

            $this->loggingService->failed('Unexpected error occurred while reset product quantity', [

                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'exception_error' => $e->getMessage(),

            ]);
        }

        return back()->with('failed',__('notifications.product_quantity_reset_failed'));
    }
}