
@extends('users.partials.app')
@section('title')
@section('content')

<div class="container mx-auto p-4 max-w-6xl">
    <h2 class="text-2xl font-bold mb-6 text-yellow-600">طلبات الاسترجاع</h2>


    @forelse($orders as $order)

    @php
    $statusColors = [
        3 => ['bg' => 'bg-yellow-50', 'border' => 'border-yellow-300', 'text' => 'text-yellow-700'],
        4 => ['bg' => 'bg-red-50', 'border' => 'border-red-300', 'text' => 'text-red-700'],
        5 => ['bg' => 'bg-green-50', 'border' => 'border-green-300', 'text' => 'text-green-700'],
    ];
    $colors = $statusColors[$order->status] ?? ['bg' => 'bg-gray-50', 'border' => 'border-gray-300', 'text' => 'text-gray-700'];
    @endphp

    <div class="{{ $colors['bg'] }} rounded-lg shadow-sm {{ $colors['border'] }} border p-4 mb-10 hover:shadow-md transition duration-200 relative">

<div class="absolute top-6 right-4 flex items-center gap-3">
    @if($order->seller?->phone_numbers)
        <span class="text-sm text-gray-600">📞 {{ $order->seller->phone_numbers }}</span>
        <a href="https://wa.me/{{ $order->seller->phone }}" target="_blank"
           class="text-green-600 hover:text-green-700 transition transform hover:scale-110">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                 class="w-5 h-5 text-green-500">
                <path
                    d="M20.5 3.5A11.78 11.78 0 0 0 12 0a12 12 0 0 0-10.61 17.49L0 24l6.76-1.76A11.94 11.94 0 0 0 12 24a12 12 0 0 0 8.49-20.5Zm-8.5 18a9.93 9.93 0 0 1-5.07-1.38l-.36-.22-4.02 1.04 1.07-3.92-.24-.4a10 10 0 1 1 8.62 4.88Zm5.68-7.66c-.31-.15-1.84-.91-2.12-1.01s-.5-.15-.72.15-.83 1.01-1.01 1.22-.37.23-.68.08a8.17 8.17 0 0 1-2.43-1.5 9.13 9.13 0 0 1-1.7-2.12c-.18-.31 0-.48.13-.63a5.38 5.38 0 0 0 .47-.61.57.57 0 0 0 0-.54c-.07-.15-.72-1.74-.99-2.38s-.52-.55-.72-.56h-.61a1.17 1.17 0 0 0-.84.4 3.54 3.54 0 0 0-1.11 2.63 6.19 6.19 0 0 0 1.3 3.17c.16.21 2.34 3.55 5.67 4.94a18.78 18.78 0 0 0 1.87.69 4.51 4.51 0 0 0 2.06.13c.63-.1 1.84-.75 2.1-1.48s.26-1.36.18-1.48-.28-.2-.59-.36Z" />
            </svg>
        </a>
    @endif
</div>


        
        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4 gap-2">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">
                    طلب رقم: <span class="text-gray-700">{{ $order->order_number }}</span>
                </h3>
                <p class="text-sm text-gray-500">تم التوصيل بتاريخ: {{ $order->delivered_at ?? 'غير متوفر' }}</p>
            </div>

            <div class="text-center my-4">
                <span class="inline-block px-4 py-2 rounded-full text-base font-semibold {{ $colors['bg'] }} {{ $colors['text'] }} border {{ $colors['border'] }}">
                    @switch($order->status)
                        @case(3) قيد مراجعة طلب الاسترجاع @break
                        @case(4) تم رفض طلب الاسترجاع @break
                        @case(5) تم قبول الاسترجاع @break
                        @default حالة غير معروفة
                    @endswitch
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm text-gray-700 mb-4">
            <div>
                <p><span class="font-medium text-gray-900">طريقة الدفع:</span> {{ $order->payment_method }}</p>
                <p><span class="font-medium text-gray-900">المبلغ المدفوع:</span> {{ $order->price }} ج.م</p>
                <p><span class="font-medium text-gray-900">عدد المنتجات:</span> {{ $order->items->sum('quantity') }}</p>
            </div>

            <div class="md:col-span-2">
                @if($order->return_reason)
                <div class="bg-white p-3 rounded border border-dashed text-sm text-gray-700">
                    <span class="font-semibold text-gray-900">سبب الاسترجاع:</span>
                    <p class="mt-1">{{ $order->return_reason }}</p>
                </div>
                @endif
            </div>
        </div>

        {{-- محتوى الطلب --}}
        <div class="border-t pt-4 mt-4">
            <h4 class="text-md font-semibold mb-2 text-gray-700">محتوى الطلب:</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($order?->items as $item)
                <div class="flex items-center gap-4 bg-white p-3 rounded-lg border">
                    <img src="{{  asset('images/'.$item->product->images->first()->path) ?? 'default.jpg' }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded-md border">
                    <div>
                        <p class="font-medium text-gray-900">{{ $item->product->name }}</p>
                        <p class="text-sm text-gray-600">العدد: {{ $item->quantity }}</p>
                        <p class="text-sm text-gray-600">السعر: {{ $item->price }} ج.م</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>

    @empty
    <div class="text-center text-gray-500 mt-12 text-lg">لا توجد طلبات استرجاع حالياً.</div>
    @endforelse
</div>

@endsection

