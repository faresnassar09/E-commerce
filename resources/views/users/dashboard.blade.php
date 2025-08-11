@extends('users.partials.app')
@section('title')
    {{ __('messages.customer_dashboard_title') }}
@endsection
@section('content')
 <div class="flex min-h-screen bg-gray-100">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <div class="container mx-auto py-8 px-4">
        <h2 class="text-3xl font-bold mb-8">{{ __('messages.customer_dashboard_title') }} 🧾</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3  lg:grid-cols-4 gap-6">


            <div class="bg-white p-6 rounded-2xl shadow-md flex items-center gap-4">
                <div class="bg-purple-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-semibold">{{ __('messages.current_orders') }}</h3>
                    <p class="text-gray-700 text-lg">{{ $data['currentOrders'] }}</p>
                </div>
            </div>


            <div class="bg-white p-6 rounded-2xl shadow-md flex items-center gap-4">
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18v6H3V3zm0 8h18v10H3V11z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-semibold">{{ __('messages.completed_orders') }}</h3>
                    <p class="text-gray-700 text-lg">{{ $data['compleatedOrders'] }}</p>
                </div>
            </div>


            <div class="bg-white p-6 rounded-2xl shadow-md flex items-center gap-4">
                <div class="bg-indigo-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582M20 20v-5h-.582M5.64 5.64l12.73 12.72" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-semibold">{{ __('messages.returned_orders') }}</h3>
                    <p class="text-gray-700 text-lg">{{ $data['returnedOrders'] }}</p>
                </div>
            </div>



            <div class="bg-white p-6 rounded-2xl shadow-md flex items-center gap-4">
                <div class="bg-red-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-semibold">{{ __('messages.canceled_orders') }}</h3>
                    <p class="text-gray-700 text-lg">{{ $data['canceledOrders'] }}</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-md flex items-center gap-4">
                <div class="bg-green-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.1 0-2 .9-2 2 0 .74.4 1.38 1 1.73V15h2v-3.27c.6-.35 1-.99 1-1.73 0-1.1-.9-2-2-2z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v2m0 14v2m-6.36-3.64l1.41 1.41M18.36 5.64l1.41-1.41M3 12h2m14 0h2M5.64 5.64l1.41 1.41M18.36 18.36l1.41-1.41" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-semibold">{{ __('messages.total_paid') }}</h3>
                    <p class="text-gray-700 text-lg">{{ $data['totalPaid'] }} {{ __('messages.aed') }}</p>
                </div>
            </div>


            <div class="bg-white p-6 rounded-2xl shadow-md flex items-center gap-4">
                <div class="bg-yellow-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v7a2 2 0 01-2 2H6a2 2 0 01-2-2v-7m16 0H4" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-semibold">{{ __('messages.number_of_items') }}</h3>
                    <p class="text-gray-700 text-lg">{{ $data['items'] }}</p>
                </div>
            </div>


        </div>
    </div>
</div>
@endsection