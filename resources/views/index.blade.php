<script src="https://cdn.tailwindcss.com"></script>
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @livewireScripts()
    @livewireStyles()

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.main_page') }}</title>
</head>
<body class="bg-gray-50 text-gray-800">

    @include('users.partials.navbar')

    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-center mx-4 sm:mx-auto sm:w-1/2">
            {{ session('success') }}
        </div>
    @endif

    <script>
        const toast = document.getElementById('toast');
        setTimeout(() => {
            toast.classList.remove('opacity-0');
            toast.classList.add('opacity-100');
        }, 100);
        setTimeout(() => {
            toast.classList.remove('opacity-100');
            toast.classList.add('opacity-0');
        }, 3300);
    </script>

    <livewire:user-search-bar />

    <section class="container mx-auto mt-10 px-4">
        <h2 class="text-xl sm:text-3xl font-bold mb-6 text-gray-800">{{ __('messages.most_sold') }}</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($products as $product)
                <div class="bg-white p-4 rounded-lg shadow-lg hover:shadow-xl transition-shadow relative">
                    <img src="{{ Storage::url($product?->images?->first()?->path) }}" class="w-full h-40 sm:h-32 object-cover rounded-md mt-4">

                    <div class="mt-4 text-left">
                        <p class="text-sm font-semibold text-gray-700">
                            {{ __('messages.store') }}: {{ $product->store->name }}
                        </p>
                        <p class="text-xs text-gray-500">
                            {{ $product->store->city_name ?? '' }} / {{ $product->store->area_name ?? '' }} / {{ $product->store->street }}
                        </p>
                    </div>

                    <h3 class="text-lg font-semibold text-gray-800 mt-2 text-right">{{ $product->name }}</h3>

                    <div class="mt-2 text-right">
                        @if($product->discount)
                            <p class="text-sm text-red-500 line-through">{{ number_format($product->price, 2) }} {{ __('messages.aed') }}</p>
                            <p class="text-green-500 font-bold">{{ number_format($product->price - $product->discount, 2) }} {{ __('messages.aed') }}</p>
                        @else
                            <p class="text-green-600 font-semibold">{{ number_format($product->price, 2) }} {{ __('messages.aed') }}</p>
                        @endif
                    </div>

                    <p class="text-gray-600 text-sm mt-2 text-right">
                        {{ Str::limit($product->description, 80) }}
                    </p>

                    <div class="flex justify-between items-center mt-4">
                        <livewire:add-to-cart :id="$product->id"/>
                        <a href="{{ route('user.product.show', $product->id) }}" class="text-sm text-blue-500 hover:underline">
                            {{ __('messages.details') }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        @include('users.products.pagination')
    </section>

    <section class="container mx-auto mt-20 px-4">
        <h2 class="text-xl sm:text-3xl font-bold mb-6 text-gray-800">{{ __('messages.stores') }}</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach ($stores as $store)
                <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-shadow p-5 flex flex-col items-center text-center">
                    <div class="w-24 h-24 rounded-full overflow-hidden mb-4 border-4 border-orange-500">
                        <img src="{{ Storage::url($store->images->first()?->path) }}" alt="Store Logo" class="w-full h-full object-cover">
                    </div>

                    <h3 class="text-lg font-bold text-gray-800 mb-1">{{ $store->name }}</h3>

                    <p class="text-sm text-gray-500 mb-2">
                        🌍 {{ $store->city_name ?? '' }}<br>
                        📍 {{ $store->area_name ?? '' }} / {{ $store->street }}
                    </p>

                    <a href="{{ route('user.store.details', $store->id) }}" class="mt-auto text-orange-600 hover:underline text-sm font-semibold">
                        {{ __('messages.view_store') }}
                    </a>
                </div>
            @endforeach
        </div>
    </section>

    <footer class="bg-gray-900 text-white p-6 mt-12">
        <div class="container mx-auto flex flex-col sm:flex-row justify-between gap-4 text-center sm:text-left">
            <div>
                <p>&copy; {{ __('messages.rights') }}</p>
            </div>
            <div class="space-x-4">
                <a href="#" class="hover:text-gray-400">{{ __('messages.privacy') }}</a>
                <a href="#" class="hover:text-gray-400">{{ __('messages.terms') }}</a>
            </div>
        </div>
    </footer>

</body>
</html>