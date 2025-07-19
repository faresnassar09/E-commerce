@extends('users.partials.app')
@section('title')
@section('content')

<div class="flex min-h-screen bg-gray-100">


<div class="container mx-auto p-4 max-w-6xl">
    <h2 class="text-2xl font-bold mb-6 text-red-600">الطلبات الملغاة</h2>

    @forelse($canceledOrders as $order)
        <div class="bg-red-50 rounded-lg shadow-sm border border-red-200 p-4 mb-10 hover:shadow-md transition duration-200">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4 gap-2">
                <div>
                    <h3 class="text-lg font-semibold text-red-800">طلب رقم: <span class="text-red-600">{{ $order->order_number }}</span></h3>
                    <p class="text-sm text-gray-500">بتاريخ: {{ $order->cancelled_at }}</p>
                </div>
                <div>
                    <span class="inline-block text-sm px-3 py-1 rounded-full bg-red-100 text-red-800">
                        ملغي
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm text-gray-700 mb-4">


                <div>
                    <p><span class="font-medium text-gray-900">الدفع:</span> {{ $order->payment_method }}</p>
                    <p><span class="font-medium text-gray-900">المجموع:</span> {{ $order->price }} ج.م</p>
                    <p><span class="font-medium text-gray-900">المنتجات:</span> {{ $order->items->sum('quantity') }}</p>
                </div>

                <div class="text-sm text-gray-500 italic text-center md:text-end">
                    لا يمكن تنفيذ أي إجراءات على الطلب الملغي.
                </div>
            </div>

            <div class="border-t pt-4 mt-4">
                <h4 class="text-md font-semibold mb-2 text-gray-700">تفاصيل العناصر:</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($order->items as $item)
                        <div class="flex items-center gap-4 bg-gray-50 p-3 rounded-lg border">
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
        <div class="text-center text-gray-500 mt-12 text-lg">لا توجد طلبات ملغاة حالياً.</div>
    @endforelse
</div>

@endsection
