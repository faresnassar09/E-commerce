@extends('sellers.partials.app')
@section('title', __('messages.store_statistics_title'))
@section('content')

<div class="container mx-auto py-8 px-4 sm:px-8 md:px-16 lg:px-24">
    <h2 class="text-3xl font-bold mb-8 text-center">📊 {{ __('messages.store_statistics_heading') }}</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach ($stores as $store)
            @php
                $totalProfit = $store->products->sum(fn($p) => $p->sold_quantity * $p->price);
            @endphp

            <div class="bg-white shadow-xl rounded-2xl overflow-hidden transition-transform duration-300 hover:scale-105 flex flex-col h-auto">
                <div class="w-full h-40 overflow-hidden">
                    <img src="{{Storage::url($store->images?->first()?->path) ?? 'default.jpg' }}"
                         alt="{{ __('messages.store_image_alt') }}"
                         class="w-full h-full object-cover">
                </div>

                <div class="p-4 flex flex-col gap-4">
                    <div>
                        <h3 class="text-xl font-semibold mb-1 text-center">{{ $store->name }}</h3>
                        <p class="text-gray-500 text-sm text-center mb-2">{{ __('messages.street') }}: {{ $store->street }}</p>

                        <div class="grid grid-cols-2 gap-4 text-center mb-4">
                            <div>
                                <p class="text-lg font-bold text-blue-600">{{ $store->products->count() }}</p>
                                <p class="text-xs text-gray-500">{{ __('messages.number_of_products') }}</p>
                            </div>
                            <div>
                                <p class="text-lg font-bold text-green-600">{{ $store->products->sum('sold_quantity') }}</p>
                                <p class="text-xs text-gray-500">{{ __('messages.number_of_sales') }}</p>
                            </div>
                            <div>
                                <p class="text-lg font-bold text-yellow-600">{{ $store->products->sum('available_quantity') }}</p>
                                <p class="text-xs text-gray-500">{{ __('messages.available_quantity') }}</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-lg font-bold text-purple-600">
                                    {{ number_format($totalProfit, 2) }} {{__('messages.currency')}}
                                </p>
                                <p class="text-xs text-gray-500">{{ __('messages.total_profit') }}</p>
                            </div>
                        </div>

                        <div class="grid gap-2 max-h-48 overflow-y-auto pr-1">
                            @foreach ($store->products as $product)
                                <div class="bg-gray-100 rounded-xl p-3 text-sm shadow-sm">
                                    <p class="font-semibold">{{ $product->name }}</p>
                                    <p>{{ __('messages.sales') }}: 
                                        <span class="text-green-700 font-semibold">
                                            {{ $product->sold_quantity }}
                                        </span>
                                    </p>
                                    <p>{{ __('messages.profit') }}: 
                                        <span class="text-purple-600 font-semibold">
                                            {{ $product->sold_quantity * $product->price }} {{__('messages.currency')}}
                                        </span>
                                    </p>
                                    <p>{{ __('messages.available') }}: 
                                        <span class="text-blue-600 font-semibold">
                                            {{ $product->available_quantity }}
                                        </span>
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection