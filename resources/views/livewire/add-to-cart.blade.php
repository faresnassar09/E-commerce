<div>
    <div class="flex items-center space-x-4">
    @if(session('failed'))
    <div class="max-w-3xl mx-auto mt-6">
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative shadow" role="alert">
            <strong class="font-bold">{{ __('messages.failed') }}!</strong>
            <span class="block sm:inline">{{ session('failed') }}</span>
        </div>
    </div>
@endif


@if(session('success'))
    <div class="max-w-3xl mx-auto mt-6">
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative shadow" role="alert">
            <strong class="font-bold">{{ __('messages.success') }}!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    </div>
@endif


        <button wire:click="Store" class="bg-orange-500 text-white p-2 rounded-lg hover:bg-orange-600 transition-colors text-sm">
            {{ __('messages.add_to_cart') }}
        </button>
    </div>
</div>
