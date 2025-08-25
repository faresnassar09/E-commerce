<div class="container mx-auto mt-6 flex justify-center">
    <div class="relative w-full max-w-2xl">
        <input
            wire:model.live="query"
            type="text"
            class="w-full p-3 pl-12 rounded-lg border-2 border-gray-300 focus:ring-2 focus:ring-orange-500 text-lg"
            placeholder="{{ __('messages.search_product') }}"
        >
        <svg class="absolute left-4 top-3 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="20" height="20">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M18.5 10a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z"></path>
        </svg>

        <button class="absolute right-0 top-0 p-3 bg-orange-500 text-white rounded-r-lg hover:bg-orange-600 transition-colors text-lg">
            {{ __('messages.search') }}
        </button>

        @if (!empty($query))
            <div class="absolute bg-white w-full mt-1 rounded-b-lg shadow-lg z-10 max-h-60 overflow-y-auto">
                @forelse($products as $product)
            <a href="{{route('user.product.show',$product->id)}}">
                    <div class="px-4 py-2 hover:bg-gray-100 cursor-pointer border-b">{{$product->name}}
</div>
                    </a>

                @empty
                    <div class="px-4 py-2 text-gray-500">
                        {{ __('messages.no_matching_products') }}
                    </div>
                @endforelse
            </div>
        @endif
    </div>
</div>