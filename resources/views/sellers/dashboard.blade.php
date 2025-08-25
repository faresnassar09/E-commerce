@extends('sellers.partials.app')
@section('title', __('messages.statistics_page_title'))
@section('content')

<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

<div class="max-w-6xl mx-auto px-4 py-8 space-y-6">
    <h2 class="text-2xl font-bold text-gray-800">📊 {{ __('messages.statistics_heading') }}</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition-all duration-300">
            <div class="flex items-center space-x-4">
                <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3 7l9 5 9-5M3 17l9 5 9-5M3 12l9 5 9-5" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-xl font-semibold text-gray-800">{{ __('messages.products_count') }}</h4>
                    <p class="text-gray-600">{{ $data['productsCount'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition-all duration-300">
            <div class="flex items-center space-x-4">
                <div class="bg-green-100 text-green-600 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3 9l1 11h16l1-11M4 6h16l1 3H3l1-3z" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-xl font-semibold text-gray-800">{{ __('messages.stores_count') }}</h4>
                    <p class="text-gray-600">{{ $data['storesCount'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition-all duration-300">
            <div class="flex items-center space-x-4">
                <div class="bg-yellow-100 text-yellow-600 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 12h6M9 16h6M4 6h16M4 6v14a2 2 0 002 2h12a2 2 0 002-2V6" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-xl font-semibold text-gray-800">{{ __('messages.orders_count') }}</h4>
                    <p class="text-gray-600">{{ $data['ordersCount'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition-all duration-300">
            <div class="flex items-center space-x-4">
                <div class="bg-purple-100 text-purple-600 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-10v10m-6 0h12" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-xl font-semibold text-gray-800">{{ __('messages.total_profit') }}</h4>
                    <p class="text-gray-600"> {{ $data['totalProfit'] }} {{ __('messages.currency') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    AOS.init();
</script>

@endsection