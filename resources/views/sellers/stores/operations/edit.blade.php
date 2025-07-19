@extends('sellers.partials.app')
@section('title', $title)
@section('content')


<div class="flex justify-center items-center min-h-screen bg-gray-100 mt-[-150px]">
    <div class="bg-white shadow-lg rounded-lg p-6 w-3/4 max-w-lg">
        <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">تعديل المتجر</h1>

        <form action="{{ route('seller.store.update', $store->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            
            <div>
                <label for="store-name" class="block text-gray-700 font-semibold mb-1">اسم المتجر:</label>
                <input type="text" id="store-name" name="name" required value="{{ $store->name }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm p-2 focus:ring focus:ring-indigo-300 @error('name') border-red-500 @enderror">
                @error('name')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="store-description" class="block text-gray-700 font-semibold mb-1">وصف المتجر:</label>
                <textarea id="store-description" name="description" required
                    class="w-full border-gray-300 rounded-lg shadow-sm p-2 focus:ring focus:ring-indigo-300 @error('name') border-red-500 @enderror">{{ $store->description }}</textarea>
                    @error('description')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <livewire:get-areas />

 
            <div class="text-center">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition">تعديل المتجر</button>
            </div>
        </form>
    </div>
</div>
@endsection
    