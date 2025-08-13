<?php

namespace App\Http\Controllers\Seller\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\Stores\EditStoreRequest;
use App\Http\Requests\Stores\StoreRequest;
use App\Models\Store\Store;
use App\Facades\AuthSeller;
use App\Services\FileServices;
use App\Services\Seller\LoggingService;
use App\Services\Seller\StoreService;
use Illuminate\Support\Facades\Gate;

class StoreController extends Controller
{

    public  $sellerId;

    public function __construct(

        public FileServices $fileServices,
        public StoreService $storeService,
        public LoggingService $loggingService,

    ) {}

    public function index()
    {
        $stores = $this->storeService->getStores();

        return view('sellers.stores.operations.index', compact('stores'));
    }

    public function create()
    {
        return view('sellers.stores.operations.create');
    }

    public function store(StoreRequest $request)
    {

        try {

            $store = $this->storeService->createStore($request);

            if ($request->hasFile('images')) {

                $imagesPaths = $this->fileServices->uploadMultipleImages(

                    $request->file('images'),
                    'stors_images'
                );

                $this->storeService->insertImages($store, $imagesPaths);
            }

            $this->loggingService->success('Store created successfully', [

                'store_id' => $store?->id,
            ]);

            return back()->with('success',__('notifications.store_created_successfully'));

        } catch (\Exception $e) {

            $this->loggingService->failed('Error occurred while createing store', [

                'exception_details' => $e->getMessage(),
            ]);

            return back()->with('failed',__('notifications.store_create_failed'));
        }
    }

    public function edit(Store $store)
    {

        Gate::forUser(AuthSeller::fullInfo())->authorize('edit', $store);

        return view('sellers.stores.operations.edit', compact('store'));
    }

    public function update(EditStoreRequest $request, Store $store)
    {

        try {

            Gate::forUser(AuthSeller::fullInfo())->authorize('update', $store);

            $this->storeService->updateStore($store, $request);

            $this->loggingService->success('Store updated successfully', [

                'store_id' => $store?->id,
            ]);

            return back()->with('success', __('notifications.store_updated_successfully'));

        } catch (\Exception $e) {

            $this->loggingService->failed('Error occurred while updating store', [

                'exception_details' => $e->getMessage(),
            ]);

            return back()->with('failed', __('notifications.store_update_failed'));
        }
    }

    public function destroy(Store $store)
    {

        try {

            Gate::forUser(AuthSeller::fullInfo())->authorize('delete', $store);

            $this->storeService->destroyStore($store);

            $this->loggingService->success('Store deleted successfully', [

                'store_id' => $store?->id,
            ]);

            return back()->with('success',__('notifications.store_deleted_successfully'));

        } catch (\Exception $e) {

            $this->loggingService->failed('Error occurred while deleting store', [

                'exception_details' => $e->getMessage(),
            ]);

        }

        return back()->with('failed',__('notifications.store_delete_failed'));
    }
}  
