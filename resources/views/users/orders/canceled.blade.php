@extends('users.partials.app')
@section('title')
    {{ __('messages.canceled_orders') }}
@endsection
@section('content')

<div class="flex min-h-screen bg-gray-100">
    <div class="container mx-auto p-4 max-w-6xl">
        <h2 class="text-2xl font-bold mb-6 text-red-600">{{ __('messages.canceled_orders_title') }}</h2>

        @forelse($canceledOrders as $order)
            <div class="bg-red-50 rounded-lg shadow-sm border border-red-200 p-4 mb-10 hover:shadow-md transition duration-200">
                <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4 gap-2">
                    <div>
                        <h3 class="text-lg font-semibold text-red-800">{{ __('messages.order_number') }}: <span class="text-red-600">{{ $order->order_number }}</span></h3>
                        <p class="text-sm text-gray-500">{{ __('messages.date') }}: {{ $order->cancelled_at }}</p>
                    </div>
                    <div>
                        <span class="inline-block text-sm px-3 py-1 rounded-full bg-red-100 text-red-800">
                            {{ __('messages.status_canceled') }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm text-gray-700 mb-4">
                    <div>
                        <p><span class="font-medium text-gray-900">{{ __('messages.payment_method') }}:</span> {{ $order->payment_method }}</p>
                        <p><span class="font-medium text-gray-900">{{ __('messages.total') }}:</span> {{ $order->price }} {{ __('messages.aed') }}</p>
                        <p><span class="font-medium text-gray-900">{{ __('messages.products_count') }}:</span> {{ $order->items->sum('quantity') }}</p>
                    </div>

                    <div class="text-sm text-gray-500 italic text-center md:text-end">
                        {{ __('messages.no_actions_on_canceled_order') }}
                    </div>
                </div>

                <div class="border-t pt-4 mt-4">
                    <h4 class="text-md font-semibold mb-2 text-gray-700">{{ __('messages.item_details') }}:</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach($order->items as $item)
                            <div class="flex items-center gap-4 bg-gray-50 p-3 rounded-lg border">
                                <img src="{{  Storage::url($item->product->images->first()->path) ?? 'default.jpg' }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded-md border">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $item->product->name }}</p>
                                    <p class="text-sm text-gray-600">{{ __('messages.quantity') }}: {{ $item->quantity }}</p>
                                    <p class="text-sm text-gray-600">{{ __('messages.price') }}: {{ $item->price }} {{ __('messages.aed') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center text-gray-500 mt-12 text-lg">{{ __('messages.no_canceled_orders_found') }}</div>
        @endforelse
    </div>
</div>

@endsection