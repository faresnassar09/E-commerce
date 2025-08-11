@extends('users.partials.app')
@section('title')
    {{ __('messages.orders') }}
@endsection
@section('content')

<div style="margin-top:-20px ; ">
    <body class="bg-gray-100 p-4 font-sans">
        <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">{{ __('messages.orders') }}</h1>
        <div class="max-w-4xl mx-auto space-y-4">
            @foreach ($orders as $order)
                <div class="bg-white rounded-lg shadow-sm p-3 border hover:shadow-md transition text-sm">
                    <div class="flex justify-between items-center mb-2">
                        <div>
                            <h2 class="font-bold text-blue-700">{{ __('messages.order') }} #{{ $order->id }}</h2>
                            <p class="text-xs text-gray-500">{{ __('messages.date') }}: {{ $order->created_at->format('Y-m-d') }}</p>
                        </div>
                        <div class="flex gap-2">
                            <button onclick="openSellerContact('{{ $order?->items?->first()?->product->seller->phone_numbers }}')" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-black" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M6.62 10.79a15.05 15.05 0 006.59 6.59l2.2-2.2a1 1 0 011.11-.21 11.72 11.72 0 003.64.58 1 1 0 011 1V20a1 1 0 01-1 1A17 17 0 013 4a1 1 0 011-1h3.5a1 1 0 011 1 11.72 11.72 0 00.58 3.64 1 1 0 01-.21 1.11l-2.2 2.2z" />
                                </svg>
                                <span>{{__('messages.contact_seller')}}</span>
                            </button>
                            @include('users.orders.partials.buttons')
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-2 text-gray-700 mb-2">
                        <div><strong>{{ __('messages.payment_method') }}:</strong> {{ $order->payment_method ?? 'كاش' }}</div>
                        <div><strong>{{ __('messages.price') }}:</strong> {{ $order->price }} </div>
                        <div><strong> {{ __('messages.backup_number') }}:</strong> {{ $order->backup_phone ?? 'Not Found' }}</div>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800 mb-1">{{ __('messages.items') }}</p>
                        <ul class="space-y-1">
                            @foreach ($order->items as $item)
                                <li class="flex items-center gap-2">
                                    <img src="{{ Storage::url($item->product->images->first()->path) ?? 'default.jpg' }}" class="w-16 h-16 object-cover rounded border">
                                    <div>
                                        <p>{{ $item->product->name }}</p>
                                        <p class="text-xs text-gray-500">{{ __('messages.price') }}: {{ $item->price }} | {{ __('messages.quantity_short') }}: {{ $item->quantity }}</p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </body>
</div>

<div id="sellerModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow p-4 w-80 text-center">
        <p class="text-gray-600 mb-4">{{ __('messages.call_seller') }}</p>
        <p id="sellerPhoneText" class="text-xl font-bold text-blue-700 mb-4">null</p>
        <button onclick="closeSellerContact()" class="bg-red-500 text-white px-4 py-1 rounded hover:bg-red-600">
            {{ __('messages.close') }}
        </button>
    </div>
</div>

<script>
    function openSellerContact(phone) {
        document.getElementById('sellerPhoneText').textContent = phone ?? '{{ __('messages.not_found') }}';
        document.getElementById('sellerModal').classList.remove('hidden');
    }

    function closeSellerContact() {
        document.getElementById('sellerModal').classList.add('hidden');
    }
</script>

@endsection