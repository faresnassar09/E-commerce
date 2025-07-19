@extends('sellers.partials.app')
@section('title')
@section('content')

@if($subscription && $subscription->active())
    
<div class="max-w-3xl mx-auto py-10 px-6">
    <div class="bg-white shadow-xl rounded-2xl p-6 space-y-6 border border-gray-200">
        <h2 class="text-2xl font-semibold text-gray-800 border-b pb-3">صفحة الفوترة</h2>

        {{-- حالة الاشتراك --}}
        <div class="bg-green-50 text-green-800 p-4 rounded-xl border border-green-200">
            اشتراكك نشط وسيتم التجديد في
            {{ $renewsAt?->format('Y:m:d') }}
            {{ '(نهاية الفترة التجريبية*)' }}    
        </div>

        {{-- تفاصيل الاشتراك --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-700">
            <div>
                <span class="font-medium">اسم الخطة:</span>
                الخطة السنوية
            </div>
            <div>
                <span class="font-medium">الحالة:</span>
                {{ $subscription->stripe_status }}
            </div>
            <div>
                <span class="font-medium">تاريخ الإنشاء:</span>
                {{ $subscription->created_at->format('Y-m-d') }}
            </div>
            <div>
                <span class="font-medium">معرف الاشتراك</span>
                <br>
                {{ $subscription->stripe_id }}
            </div>
        </div>

        <form action="{{route('seller.subscription.cancel')}}" method="POST" class="pt-4">
        @csrf
        @method('DELETE')

            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl shadow-md">
                إلغاء الاشتراك
            </button>
        </form>
    </div>
</div>

@else
<div class="max-w-md mx-auto py-10 px-6">
    <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-200">
        <h3 class="text-2xl font-bold mb-4 text-gray-900">اشتراك سنوي</h3>
        <p class="text-gray-600 mb-6">سعر الاشتراك: <span class="text-xl font-semibold text-green-600">100 دولار</span> سنويًا</p>
        
        <ul class="mb-6 text-gray-700 space-y-2">
            <li class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 01.083 1.32l-.083.094L9 14.414l-3.707-3.707a1 1 0 011.32-1.497l.094.083L9 12.586l6.293-6.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                وصول كامل لجميع الميزات
            </li>
            <li class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 01.083 1.32l-.083.094L9 14.414l-3.707-3.707a1 1 0 011.32-1.497l.094.083L9 12.586l6.293-6.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                دعم فني على مدار الساعة
            </li>
            <li class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 01.083 1.32l-.083.094L9 14.414l-3.707-3.707a1 1 0 011.32-1.497l.094.083L9 12.586l6.293-6.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                إمكانية إلغاء الاشتراك في أي وقت
            </li>
        </ul>

        <form action="{{route('seller.subscription.create')}}" method="POST">
            @csrf
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl shadow-md transition duration-300">
                اشترك الآن
            </button>
        </form>
    </div>
</div>
@endif
@endsection