@extends('sellers.partials.app')
@section('title', __('messages.delivered_orders_title'))
@section('content')

<div class="container mx-auto p-4 max-w-6xl">
    <h2 class="text-2xl font-bold mb-6 text-green-600">{{__('messages.delivered_orders_heading')}}</h2>

    @forelse($orders as $order)
    <div class="bg-green-50 rounded-lg shadow-sm border border-green-200 p-4 mb-10 hover:shadow-md transition duration-200 relative">

        <div id="returnModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-xl">
                <h2 class="text-lg font-semibold mb-4">{{__('messages.return_reason_heading')}}</h2>
                <form id="returnForm" method="POST" action="{{route('user.orders.return')}}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="order_id" id="modal_order_id">
                    <textarea name="reason" rows="4" class="w-full border border-gray-300 rounded p-2 mb-4" placeholder="{{__('messages.write_reason_placeholder')}}" required></textarea>
                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="closeReturnModal()" class="px-4 py-2 bg-gray-300 rounded">{{__('messages.cancel_button')}}</button>
                        <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">{{__('messages.confirm_button')}}</button>
                    </div>
                </form>
            </div>
        </div>


        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4 gap-2">
            <div>
                <h3 class="text-lg font-semibold text-green-800">
                    {{__('messages.order_number')}}: <span class="text-green-700">{{ $order->order_number }}</span>
                </h3>
                <p class="text-sm text-gray-500">{{__('messages.delivered_on_date')}}: {{ $order->delivered_at ?? __('messages.not_available') }}</p>
            </div>
            <div>
                <span class="inline-block text-sm px-3 py-1 rounded-full bg-green-100 text-green-800">
                    {{__('messages.delivered_status')}}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm text-gray-700 mb-4">
            <div>
                <p><span class="font-medium text-gray-900">{{__('messages.payment_method')}}:</span> {{ $order->payment_method }}</p>
                <p><span class="font-medium text-gray-900">{{__('messages.amount_paid')}}:</span> {{ $order->price }} {{__('messages.aed')}}</p>
                <p><span class="font-medium text-gray-900">{{__('messages.products_count')}}:</span> {{ $order->items->sum('quantity') }}</p>
            </div>

            <div class="text-sm text-gray-600 italic text-center md:text-end">
                {{__('messages.no_further_action')}}
            </div>
        </div>

        <div class="border-t pt-4 mt-4">
            <h4 class="text-md font-semibold mb-2 text-gray-700">{{__('messages.order_content')}}:</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($order->items as $item)
                <div class="flex items-center gap-4 bg-white p-3 rounded-lg border">
                    <img src="{{ Storage::url($item->product->images->first()->path) }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded-md border">
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
    <div class="text-center text-gray-500 mt-12 text-lg">{{__('messages.no_delivered_orders')}}</div>
    @endforelse
</div>


<script>
    function openReturnModal(orderId) {
        document.getElementById('modal_order_id').value = orderId;
        document.getElementById('returnModal').classList.remove('hidden');
    }

    function closeReturnModal() {
        document.getElementById('returnModal').classList.add('hidden');
    }
</script>

@endsection