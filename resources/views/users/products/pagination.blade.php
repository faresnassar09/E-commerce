 @if ($products->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center items-center space-x-2 mt-10">
        {{-- Previous Page Link --}}
        @if ($products->onFirstPage())
            <span class="px-4 py-2 text-lg text-gray-500 bg-gray-200 rounded-lg cursor-not-allowed">
                ←
            </span>
        @else
            <a href="{{ $products->previousPageUrl() }}" class="px-4 py-2 text-lg text-white bg-blue-600 hover:bg-blue-700 rounded-lg">
                ←
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($products->links()->elements[0] ?? [] as $page => $url)
            @if ($page == $products->currentPage())
                <span class="px-4 py-2 text-lg text-white bg-blue-600 rounded-lg">{{ $page }}</span>
            @else
                <a href="{{ $url }}" class="px-4 py-2 text-lg text-blue-600 hover:bg-blue-100 rounded-lg">{{ $page }}</a>
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($products->hasMorePages())
            <a href="{{ $products->nextPageUrl() }}" class="px-4 py-2 text-lg text-white bg-blue-600 hover:bg-blue-700 rounded-lg">
                → 
            </a>
        @else
            <span class="px-4 py-2 text-lg text-gray-500 bg-gray-200 rounded-lg cursor-not-allowed">
                →
            </span>
        @endif
    </nav>
@endif 
