@extends('sellers.partials.app')
@section('title', __('messages.product_statistics_title'))
@section('content')

@php
    $sortedProducts = $products->sortByDesc('sold_quantity')->values();
@endphp

@include('layouts.messages')

<div class="p-4 bg-white shadow-md rounded-lg max-w-full">
    @foreach ($sortedProducts as $index => $product)
        <div class="flex flex-col sm:flex-row items-center justify-between border-b border-gray-200 py-4 px-2 gap-4">

            <div class="text-xl font-bold text-gray-700 text-center sm:w-8">
                {{ $index + 1 }}
            </div>

            <div class="flex items-center gap-4">
                <img src="{{ Storage::url($product->images?->first()?->path) ?? 'default.jpg'}}" 
                     class="w-14 h-14 object-cover rounded-md shadow-md">
                <h3 class="text-lg font-semibold text-gray-800">{{ $product['name'] }}</h3>
            </div>

            <div class="w-20 h-20">
                <canvas id="chart-{{ $product['id'] }}"></canvas>
            </div>

            <div class="flex flex-wrap justify-center gap-4 text-center sm:text-right">
                <form action="{{route('seller.statics.resetquantity')}}" method="post">
                    @csrf
                    @method('PATCH')
                    <button type="submit" value="{{$product->id}}" name="product_id"
                            class="bg-red-600 hover:bg-red-700 text-white py-1 px-3 rounded shadow">
                        {{ __('messages.reset_quantity') }}
                    </button>
                </form>

                <span class="text-red-600 font-medium bg-red-100 px-3 py-1 rounded">
                    {{ __('messages.sold_quantity') }}: {{ $product['sold_quantity'] }}
                </span>
                <span class="text-green-600 font-medium bg-green-100 px-3 py-1 rounded">
                    {{ __('messages.available') }}: {{ $product['available_quantity'] }}
                </span>

                <div class="flex gap-2">
                    <button onclick="openModal('increase', {{ $product->id }}, '{{ $product->name }}')" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                        +
                    </button>
                    <button onclick="openModal('decrease', {{ $product->id }}, '{{ $product->name }}')" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                        -
                    </button>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                var ctx = document.getElementById("chart-{{ $product['id'] }}").getContext("2d");
                new Chart(ctx, {
                    type: "doughnut",
                    data: {
                        labels: ["{{ __('messages.sold_quantity') }}", "{{ __('messages.available') }}"],
                        datasets: [{
                            data: [{{ $product['sold_quantity'] }}, {{ $product['available_quantity'] }}],
                            backgroundColor: ["#f87171", "#34d399"]
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            });
        </script>
    @endforeach
</div>

<div id="quantityModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
        <h2 id="modalTitle" class="text-2xl font-semibold mb-4"></h2>
        <form method="POST" action="" id="quantityForm">
            @csrf
            @method('PATCH')
            <input type="hidden" name="product_id" id="modalProductId">
            <input type="number" name="quantity" placeholder="{{ __('messages.enter_quantity') }}" class="w-full border p-2 rounded mb-4" required min="1">
            <div class="flex justify-end gap-4">
                <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">{{ __('messages.cancel') }}</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">{{ __('messages.confirm') }}</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(action, productId, productName) {
        const modal = document.getElementById('quantityModal');
        const title = document.getElementById('modalTitle');
        const form = document.getElementById('quantityForm');
        const productIdInput = document.getElementById('modalProductId');
        
        productIdInput.value = productId;
        title.innerText = (action === 'increase' ? '{{ __('messages.increase_quantity_for') }}' : '{{ __('messages.decrease_quantity_for') }}') + ' ' + productName;
        form.action = action === 'increase' 
            ? '{{ route("seller.statics.increase") }}' 
            : '{{ route("seller.statics.decrease") }}';

        modal.classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('quantityModal').classList.add('hidden');
    }
</script>
@endsection