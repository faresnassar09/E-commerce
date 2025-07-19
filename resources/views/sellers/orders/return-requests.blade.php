@extends('sellers.partials.app')
@section('title')
@section('content')

<div class="container mx-auto p-4 max-w-6xl">
    <h2 class="text-2xl font-bold mb-6 text-yellow-600">طلبات الاسترجاع قيد المراجعة</h2>


    @forelse($orders as $order)
    @if($order->status == 3)
    <div class="bg-yellow-50 rounded-lg shadow-sm border border-yellow-200 p-4 mb-10 hover:shadow-md transition duration-200 relative">

        <!-- أزرار البائع -->
        <div class="absolute top-4 right-4 flex gap-2">
            <!-- زر قبول -->
            <form method="POST" action="{{route('seller.orders.return.accept',$order->id)}}">
                @csrf
                @method('PATCH')
                <input type="hidden" name="order_id" value="{{ $order->id }}">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 flex items-center gap-1 shadow text-sm">
                    ✅ قبول المرتجع
                </button>
            </form>

            <!-- زر رفض -->
            <form method="POST" action="{{route('seller.orders.return.reject',$order->id)}}">
                @csrf
                @method('PATCH')
                <input type="hidden" name="order_id" value="{{ $order->id }}">
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 flex items-center gap-1 shadow text-sm">
                    ❌ رفض المرتجع
                </button>
            </form>
        </div>

        <!-- معلومات الطلب -->
        <div class="text-center my-4">
            <span class="inline-block px-4 py-2 rounded-full text-base font-semibold bg-yellow-100 text-yellow-800 border border-yellow-300">
                قيد مراجعة طلب الاسترجاع
            </span>
        </div>

        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4 gap-2">
            <div>
                <h3 class="text-lg font-semibold text-yellow-800">
                    طلب رقم: <span class="text-yellow-700">{{ $order->order_number }}</span>
                </h3>
                <p class="text-sm text-gray-500">تاريخ الطلب: {{ $order->created_at->format('Y-m-d') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm text-gray-700 mb-4">
            <div>
                <p><span class="font-medium text-gray-900">طريقة الدفع:</span> {{ $order->payment_method }}</p>
                <p><span class="font-medium text-gray-900">المبلغ المدفوع:</span> {{ $order->price }} ج.م</p>
                <p><span class="font-medium text-gray-900">عدد المنتجات:</span> {{ $order->items->sum('quantity') }}</p>
            </div>
            <div class="text-sm text-gray-600 italic text-center md:text-end">
                هذا الطلب ينتظر مراجعة طلب الاسترجاع من قِبل البائع.
            </div>
        </div>

        <div class="border-t pt-4 mt-4">
            <h4 class="text-md font-semibold mb-2 text-gray-700">محتوى الطلب:</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($order->items as $item)
                <div class="flex items-center gap-4 bg-white p-3 rounded-lg border">
                    <img src="{{ asset('images/'.$item->product->images->first()->path) }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded-md border">
                    <div>
                        <p class="font-medium text-gray-900">{{ $item->product->name }}</p>
                        <p class="text-sm text-gray-600">العدد: {{ $item->quantity }}</p>
                        <p class="text-sm text-gray-600">السعر: {{ $item->price }} ج.م</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        @if($order->log)
        <div class="border-t pt-4 mt-4">
            <h4 class="text-md font-semibold mb-2 text-gray-700">{{ $order->log->title }}</h4>
            <p class="text-sm text-red-600 italic">{{ $order->log->details }}</p>
        </div>
        @endif
    </div>
    @endif
    @empty
    <div class="text-center text-gray-500 mt-12 text-lg">لا توجد طلبات استرجاع حالياً.</div>
    @endforelse
</div>

@endsection