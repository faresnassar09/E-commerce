@extends('users.partials.app')
@section('title')
@section('content')
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<div class="container mx-auto p-4 max-w-6xl">
    <h2 class="text-2xl font-bold mb-6 text-green-600">الطلبات المُوصلة</h2>


    @forelse($orders as $order)
    <div class="bg-green-50 rounded-lg shadow-sm border border-green-200 p-4 mb-10 hover:shadow-md transition duration-200 relative">


        <div class="absolute top-4 right-4">
            <button onclick="openReturnModal({{ $order->id }})" type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 flex items-center gap-2 shadow">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h4l3-3m0 0l3 3h4m-7-3v12" />
                </svg>
                طلب استرجاع
            </button>
        </div>


        <!-- المودال -->
        <div id="returnModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-xl">
                <h2 class="text-lg font-semibold mb-4">سبب الاسترجاع</h2>
                <form id="returnForm" method="POST" action="{{route('user.orders.return')}}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="order_id" id="modal_order_id">
                    <textarea name="reason" rows="4" class="w-full border border-gray-300 rounded p-2 mb-4" placeholder="اكتب السبب هنا..." required></textarea>
                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="closeReturnModal()" class="px-4 py-2 bg-gray-300 rounded">إلغاء</button>
                        <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">تأكيد</button>
                    </div>
                </form>
            </div>
        </div>


        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4 gap-2">
            <div>
                <h3 class="text-lg font-semibold text-green-800">
                    طلب رقم: <span class="text-green-700">{{ $order->order_number }}</span>
                </h3>
                <p class="text-sm text-gray-500">تم التوصيل بتاريخ: {{ $order->delivered_at ?? 'غير متوفر' }}</p>
            </div>
            <div>
                <span class="inline-block text-sm px-3 py-1 rounded-full bg-green-100 text-green-800">
                    تم التوصيل بنجاح
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm text-gray-700 mb-4">
            <div>
                <p><span class="font-medium text-gray-900">طريقة الدفع:</span> {{ $order->payment_method }}</p>
                <p><span class="font-medium text-gray-900">المبلغ المدفوع:</span> {{ $order->price }} ج.م</p>
                <p><span class="font-medium text-gray-900">عدد المنتجات:</span> {{ $order->items->sum('quantity') }}</p>
            </div>

            <div class="text-sm text-gray-600 italic text-center md:text-end">
                تم توصيل هذا الطلب بنجاح للعميل. لا توجد إجراءات أخرى مطلوبة.
            </div>
        </div>

        <div class="border-t pt-4 mt-4">
            <h4 class="text-md font-semibold mb-2 text-gray-700">محتوى الطلب:</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($order->items as $item)
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
    <div class="text-center text-gray-500 mt-12 text-lg">لا توجد طلبات مُوصلة حالياً.</div>
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

