@extends('sellers.partials.app')
@section('title', __('messages.incoming_orders_title'))
@section('content')
@livewireScripts()
@livewireStyles()
 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

<div class="container mx-auto p-4 max-w-6xl">
    <h2 class="text-2xl font-bold mb-6">{{__('messages.incoming_orders_heading')}}</h2>

    @forelse($orders as $order)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-10 hover:shadow-md transition duration-200">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4 gap-2">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">{{__('messages.order_number')}}: <span class="text-blue-600">{{ $order->order_number }}</span></h3>
                    <p class="text-sm text-gray-500">{{__('messages.on_date')}}: {{ $order->created_at->format('Y-m-d H:i') }}</p>
                </div>
                <div>
                    <span class="inline-block text-sm px-3 py-1 rounded-full
                        @switch($order->status)
                            @case(0) bg-yellow-100 text-yellow-800 @break
                            @case(1) bg-blue-100 text-blue-800 @break
                            @case(2) bg-green-100 text-green-800 @break
                            @default bg-gray-100 text-gray-800
                        @endswitch
                    ">
                        @switch($order->status)
                            @case(0) {{__('messages.status_pending')}} @break
                            @case(1) {{__('messages.status_processing')}} @break
                            @case(2) {{__('messages.status_delivered')}} @break
                            @default {{__('messages.status_unknown')}}
                        @endswitch
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm text-gray-700 mb-4">
                <div>
                    <p><span class="font-medium text-gray-900">{{__('messages.customer_name')}}:</span> {{ $order->user->name }}</p>
                    <p><span class="font-medium text-gray-900">{{__('messages.phone')}}:</span> {{ $order->user->phone }}</p>
                    <p>
                        <span class="font-medium text-gray-900">{{__('messages.address')}}:</span>
                        {{__('messages.street')}} {{ $order?->userAddress?->street }},
                        {{__('messages.area')}} {{ $order?->userAddress?->area->name }},
                        {{__('messages.city')}} {{ $order?->userAddress?->city->name  }}
                    </p>
                </div>

                <div>
                    <p><span class="font-medium text-gray-900">{{__('messages.payment_method')}}:</span> {{ $order->payment_method }}</p>
                    <p><span class="font-medium text-gray-900">{{__('messages.total')}}:</span> {{ $order->price }} {{__('messages.aed')}}</p>
                    <p><span class="font-medium text-gray-900">{{__('messages.products_count')}}:</span> {{ $order->items->sum('quantity') }}</p>
                </div>

                <div class="flex md:justify-end items-center mt-2 md:mt-0 gap-2 flex-wrap">
                    <livewire:change-order-status :orderId="$order->id" />
                    <a href="https://wa.me/{{ $order->user->phone }}" target="_blank"
                        class="text-white bg-green-500 hover:bg-green-600 transition px-3 py-2 rounded-lg text-sm flex items-center justify-center"
                        title="{{__('messages.whatsapp_title')}}">
                        <i class="fab fa-whatsapp text-lg"></i>
                    </a>
                </div>
            </div>

            <div class="border-t pt-4 mt-4">
                <h4 class="text-md font-semibold mb-2 text-gray-700">{{__('messages.item_details_heading')}}:</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($order->items as $item)
                        <div class="flex items-center gap-4 bg-gray-50 p-3 rounded-lg border">
                            <img src="{{ Storage::url($item->product->images?->first()?->path) }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded-md border">
                            <div>
                                <p class="font-medium text-gray-900">{{ $item->product->name }}</p>
                                <p class="text-sm text-gray-600">{{__('messages.quantity')}}: {{ $item->quantity }}</p>
                                <p class="text-sm text-gray-600">{{__('messages.price')}}: {{ $item->price }} {{__('messages.aed')}}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @empty
        <div class="text-center text-gray-500 mt-12 text-lg">{{__('messages.no_orders_found')}}</div>
    @endforelse
</div>

@endsection