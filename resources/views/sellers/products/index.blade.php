@extends('sellers.partials.app')
@section('title', __('messages.products_title'))
@section('content')

<div class="container mx-auto p-4 sm:p-6 max-w-screen-xl">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 justify-center">
        @foreach($products as $product)
            <div class="bg-white shadow-md rounded-lg overflow-hidden p-2 relative border border-gray-300 max-w-full w-full transition-transform hover:scale-105">
                
                <img src="{{ Storage::url($product->images?->first()?->path) }}" alt="{{ $product->name }}" class="w-full h-32 object-cover rounded-t-md">
                
                <h2 class="text-sm font-bold text-gray-900 mt-2 text-center">{{ $product->name }}</h2>
                
                <div class="mt-1 text-center">
                    @if($product->discount > 0)
                        <span class="text-gray-500 line-through text-sm block">{{ $product->price }} {{__('messages.aed')}}</span>
                    @endif
                    <span class="text-black font-semibold text-sm">{{ $product->price - $product->discount }} {{__('messages.aed')}}</span>
                </div>

                <div class="flex flex-wrap justify-center gap-2 bg-gray-100 p-2 mt-3 rounded-md">
                    <a href="{{ route('user.product.show', $product->id) }}"
                       class="bg-blue-500 text-white px-3 py-1 rounded text-sm">
                        {{ __('messages.show') }}
                    </a>

                    <form action="{{ route('seller.product.delete', $product->id) }}" method="POST"
                          onsubmit="return confirm('{{ __('messages.confirm_delete_product') }}')" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="bg-red-500 text-white px-3 py-1 rounded text-sm">
                            {{ __('messages.delete') }}
                        </button>
                    </form>

                    <a href="#"
                       onclick="openEditModal({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, {{ $product->discount }}, '{{ addslashes($product->description) }}')"
                       class="bg-yellow-500 text-white px-3 py-1 rounded text-sm">
                        {{ __('messages.edit') }}
                    </a>
                </div>
            </div>

            @include('sellers.products.edit', ['product' => $product])
        @endforeach
    </div>

    <div class="mt-6 flex justify-center">
        {{ $products->links() }}
    </div>
</div>

<script>
    function openEditModal(id, name, price, discount, description) {
        document.getElementById('editModal-' + id).classList.remove('hidden');
        document.getElementById('editName-' + id).value = name;
        document.getElementById('editPrice-' + id).value = price;
        document.getElementById('editDiscount-' + id).value = discount;
        document.getElementById('editDescription-' + id).value = description;
    }

    function closeEditModal(id) {
        document.getElementById('editModal-' + id).classList.add('hidden');
    }
</script>
@endsection