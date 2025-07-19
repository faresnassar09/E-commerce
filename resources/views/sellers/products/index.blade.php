@extends('sellers.partials.app')
@section('title', $title)
@section('content')



<div class="container mx-auto p-4 sm:p-6 max-w-screen-xl">
    <!-- شبكة المنتجات -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 justify-center">
        @foreach($products as $product)
            <div class="bg-white shadow-md rounded-lg overflow-hidden p-2 relative border border-gray-300 max-w-full w-full transition-transform hover:scale-105">
                
                <!-- صورة المنتج -->
                <img src="{{asset('images/'.$product->images?->first()?->path) ?? null}}" class="w-full h-32 object-cover rounded-t-md">
                
                <!-- اسم المنتج -->
                <h2 class="text-sm font-bold text-gray-900 mt-2 text-center">{{ $product->name }}</h2>
                
                <!-- السعر والخصم -->
                <div class="mt-1 text-center">
                    @if($product->discount > 0)
                        <span class="text-gray-500 line-through text-sm block">{{ $product->price }} EG</span>
                    @endif
                    <span class="text-black font-semibold text-sm">{{ $product->price - $product->discount }} EG</span>
                </div>

                <!-- أزرار التحكم -->
                <div class="flex flex-wrap justify-center gap-2 bg-gray-100 p-2 mt-3 rounded-md">
                    {{-- زر Show --}}
                    <a href="{{ route('user.product.show', $product->id) }}"
                       class="bg-blue-500 text-white px-3 py-1 rounded text-sm">
                        {{ __('messages.show') }}
                    </a>

                    {{-- زر Delete --}}
                    <form action="{{ route('seller.product.delete', $product->id) }}" method="POST"
                          onsubmit="return confirm('هل أنت متأكد من الحذف؟')" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="bg-red-500 text-white px-3 py-1 rounded text-sm">
                            {{ __('messages.delete') }}
                        </button>
                    </form>

                    {{-- زر Edit --}}
                    <a href="#"
                       onclick="openEditModal({{ $product->id }}, '{{ $product->name }}', {{ $product->price }}, {{ $product->discount }}, '{{ $product->description }}')"
                       class="bg-yellow-500 text-white px-3 py-1 rounded text-sm">
                        {{ __('messages.edit') }}
                    </a>
                </div>
            </div>

            <!-- النافذة المنبثقة للتعديل -->
            @include('sellers.products.edit')
        @endforeach
    </div>

    <!-- أزرار التنقل بين الصفحات -->
    <div class="mt-6 flex justify-center">
        {{ $products->links() }}
    </div>
</div>


<!-- سكريبت التحكم في النافذة المنبثقة -->
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
