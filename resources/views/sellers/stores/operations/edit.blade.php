@extends('sellers.partials.app')
@section('title', __('messages.edit_store_title'))
@section('content')

<div class="flex justify-center items-center min-h-screen bg-gray-100 mt-[-150px]">
    <div class="bg-white shadow-lg rounded-lg p-6 w-3/4 max-w-lg">
        <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">{{ __('messages.edit_store_heading') }}</h1>

        <form action="{{ route('seller.store.update', $store->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label for="store-name" class="block text-gray-700 font-semibold mb-1">{{ __('messages.store_name') }}:</label>
                <input type="text" id="store-name" name="name" required value="{{ $store->name }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm p-2 focus:ring focus:ring-indigo-300 @error('name') border-red-500 @enderror">
                @error('name')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="store-description" class="block text-gray-700 font-semibold mb-1">{{ __('messages.store_description') }}:</label>
                <textarea id="store-description" name="description" required
                    class="w-full border-gray-300 rounded-lg shadow-sm p-2 focus:ring focus:ring-indigo-300 @error('description') border-red-500 @enderror">{{ $store->description }}</textarea>
                @error('description')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="street" class="block text-gray-700 font-semibold mb-1">{{ __('messages.street') }}</label>
                <textarea id="street" name="street" required
                    class="w-full border-gray-300 rounded-lg shadow-sm p-2 focus:ring focus:ring-indigo-300 @error('street') border-red-500 @enderror">{{ $store->street }}</textarea>
                @error('street')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="text-center">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition">{{ __('messages.update_store') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection