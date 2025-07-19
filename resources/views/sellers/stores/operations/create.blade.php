@extends('sellers.partials.app')
@section('title', $title)
@section('content')

 <div class="flex justify-center items-center min-h-screen bg-gray-100 mt-[-150px] mb-38">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
        <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">إنشاء متجر جديد</h1>
        
        <form action="{{ route('seller.store.create.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            
            <div>

                <label for="store-name" class="block text-sm font-medium text-gray-700">اسم المتجر:</label>
                <input type="text" id="store-name" name="name" placeholder="ادخل اسم المتجر" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="store-description" class="block text-sm font-medium text-gray-700">وصف المتجر:</label>
                <textarea id="store-description" name="description" placeholder="ادخل وصفاً للمتجر" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('description') border-red-500 @enderror"></textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <livewire:get-areas />

            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">صورة البروفايل:</label>
                <input type="file" id="image" name="images[]" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 cursor-pointer @error('images') border-red-500 @enderror" multiple>
                @if ($errors->has('images.*'))
                    @foreach ($errors->all() as $error)
                        <p class="text-red-500 text-sm mt-1">{{ $error }}</p>
                    @endforeach
                @endif
            </div>
            
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg">إنشاء المتجر</button>
        </form>
    </div>
</div>
@endsection
