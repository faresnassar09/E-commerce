
@extends('sellers.partials.app')
@section('title')
@section('content')
@livewireScripts()
@livewireStyles()
  
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

<div class="container mx-auto p-4 max-w-6xl">
    <h2 class="text-2xl font-bold mb-6">الطلبات الواردة</h2>



    @forelse($orders as $order) 
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-10 hover:shadow-md transition duration-200">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4 gap-2">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">طلب رقم: <span class="text-blue-600">{{ $order->order_number }}</span></h3>
                    <p class="text-sm text-gray-500">بتاريخ: {{ $order->created_at->format('Y-m-d H:i') }}</p>
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
                            @case(0) في الانتظار @break
                            @case(1) قيد التجهيز @break
                            @case(2) تم التوصيل @break
                            @default غير معروف
                        @endswitch
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm text-gray-700 mb-4">
                <div>
                    <p><span class="font-medium text-gray-900">العميل:</span> {{ $order->user->name }}</p>
                    <p><span class="font-medium text-gray-900">الهاتف:</span> {{ $order->user->phone }}</p>
                    <p>
                        <span class="font-medium text-gray-900">العنوان:</span>
                        شارع {{ $order?->userAddress?->street }},
                        منطقة {{ $order?->userAddress?->area->name }},
                       مدينة {{ $order?->userAddress?->city->name  }}
                    </p>
                </div>

                <div>
                    <p><span class="font-medium text-gray-900">الدفع:</span> {{ $order->payment_method }}</p>
                    <p><span class="font-medium text-gray-900">المجموع:</span> {{ $order->price }} ج.م</p>
                    <p><span class="font-medium text-gray-900">المنتجات:</span> {{ $order->items->sum('quantity') }}</p>
                </div>

                <div class="flex md:justify-end items-center mt-2 md:mt-0 gap-2 flex-wrap">
                    

<livewire:change-order-status :orderId="$order->id" /> 

                    <button class="text-sm bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition">رفض</button>

                    
                    <a href="https://wa.me/{{ $order->user->phone }}" target="_blank"
                        class="text-white bg-green-500 hover:bg-green-600 transition px-3 py-2 rounded-lg text-sm flex items-center justify-center"
                        title="راسل العميل على واتساب">
                        <i class="fab fa-whatsapp text-lg"></i>
                    </a>
                </div>
            </div>

            
            <div class="border-t pt-4 mt-4">
                <h4 class="text-md font-semibold mb-2 text-gray-700">تفاصيل العناصر:</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($order->items as $item)
                        <div class="flex items-center gap-4 bg-gray-50 p-3 rounded-lg border">
                            <img src="{{ asset('images/'.$item->product->images?->first()?->path) }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded-md border">
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
        <div class="text-center text-gray-500 mt-12 text-lg">لا توجد طلبات حالياً.</div>
    @endforelse
</div>

@endsection
