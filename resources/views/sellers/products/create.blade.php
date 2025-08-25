@extends('sellers.partials.app')
@section('title', __('messages.add_product_title'))
@section('content')

<form action="{{ route('seller.product.store') }}" method="POST" enctype="multipart/form-data" class="max-w-lg mx-auto bg-white p-4 rounded-lg shadow-md mt-6">
    @csrf

    <h2 class="text-lg font-bold mb-4 text-center"> {{ __('messages.add_product') }} </h2>

    <div class="grid grid-cols-2 gap-3 text-sm">
        <div>
            <label class="block mb-1 font-semibold">{{__('messages.store')}}</label>
            <select name="store_id" class="w-full p-1 border rounded @error('store_id') border-red-500 @enderror">
                @foreach ($stores as $store)
                    <option value="{{ $store->id }}">{{ $store->name }}</option>
                @endforeach
            </select>
            @error('store_id')
                <p class="text-red-500 text-xs">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block mb-1 font-semibold">{{__('messages.name')}}</label>
            <input type="text" name="name" class="w-full p-1 border rounded @error('name') border-red-500 @enderror" value="{{ old('name') }}">
            @error('name')
                <p class="text-red-500 text-xs">{{ $message }}</p>
            @enderror
        </div>

        <div class="col-span-2">
            <label class="block mt-3 mb-1 font-semibold"> {{__('messages.description')}}</label>
            <textarea name="description" class="w-full p-1 border rounded @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-xs">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block mt-3 mb-1 font-semibold">{{__('messages.price')}}</label>
            <input type="number" step="0.01" name="price" class="w-full p-1 border rounded @error('price') border-red-500 @enderror" value="{{ old('price') }}">
            @error('price')
                <p class="text-red-500 text-xs">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block mt-3 mb-1 font-semibold">{{__('messages.quantity')}}</label>
            <input type="number" name="quantity" class="w-full p-1 border rounded @error('quantity') border-red-500 @enderror" value="{{ old('quantity') }}">
            @error('quantity')
                <p class="text-red-500 text-xs">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block mt-3 mb-1 font-semibold">{{__('messages.descount')}} (%)</label>
            <input type="number" step="0.01" name="discount" class="w-full p-1 border rounded @error('discount') border-red-500 @enderror" value="{{ old('discount') }}">
            @error('discount')
                <p class="text-red-500 text-xs">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block mt-3 mb-1 font-semibold">{{__('messages.categories')}}</label>
            <select name="category_id" class="w-full p-1 border rounded @error('category_id') border-red-500 @enderror">
                <option value="">{{ __('messages.choose_category') }}</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <p class="text-red-500 text-xs">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <label class="block mt-3 mb-1 font-semibold">{{ __('messages.images') }} </label>
    <input
        type="file"
        name="images[]"
        multiple
        accept="image/*"
        class="w-full p-1 border rounded @error('images') border-red-500 @enderror"
        id="image-upload">

    @error('images')
        <p class="text-red-500 text-xs">{{ $message }}</p>
    @enderror

    @foreach ($errors->get('images.*') as $messages)
        @foreach ($messages as $message)
            <p class="text-red-500 text-xs">{{ $message }}</p>
        @endforeach
    @endforeach


    <div id="image-preview" class="mt-3 grid grid-cols-3 gap-2"></div>

    <button type="submit" class="mt-4 bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded w-full text-sm"> {{__('messages.add')}}</button>
</form>

<script>
    document.getElementById('image-upload').addEventListener('change', function(event) {
        let previewContainer = document.getElementById('image-preview');
        previewContainer.innerHTML = "";
        
        Array.from(event.target.files).forEach(file => {
            let reader = new FileReader();
            reader.onload = function(e) {
                let img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('w-16', 'h-16', 'object-cover', 'rounded', 'shadow-md');
                previewContainer.appendChild(img);
            }
            reader.readAsDataURL(file);
        });
    });
</script>

@endsection