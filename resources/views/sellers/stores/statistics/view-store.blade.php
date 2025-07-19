@vite('resources/css/app.css')
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<div class="max-w-7xl mx-auto px-4 py-6 space-y-6">

    <div id="store-card"
        class="opacity-0 translate-y-6 transition duration-700 bg-white border border-gray-200 rounded-2xl shadow-md p-6 flex flex-col md:flex-row justify-between items-start gap-2">

        <div class="flex flex-col gap-3 w-full md:w-1/2">
            <div class="space-y-1">
                <h1 class="text-2xl font-bold text-gray-800">{{ $store->name }}</h1>
                <p class="text-sm text-gray-600">{{ $store->city_name. '/'}}{{$store->area_name .'/' }}{{ $store->street }}</p>

            </div>
  
            <a href="{{'https://quickchart.io/qr?text='.url()->current();}}"> انقر للحصول علي ال qr code</a>
           
            <a href="{{url()->current()}}">

            رابط المتجر {{ url()->current() }}
            </a>


            
            <div class="flex gap-2">
                <div class="flex-1 bg-blue-50 border border-blue-200 text-blue-800 rounded-lg p-3 text-center shadow-sm">
                    🥛 <div class="font-bold text-sm">الألبان</div>
                    <div class="text-xs">{{ $categories['milks'] ?? 0 }} منتج</div>
                </div>

                <div class="flex-1 bg-yellow-50 border border-yellow-200 text-yellow-800 rounded-lg p-3 text-center shadow-sm">
                    🌾 <div class="font-bold text-sm">العلافة</div>
                    <div class="text-xs">{{ $categories['grains']}} منتج</div>
                </div>
                <div class="flex-1 bg-green-50 border border-green-200 text-green-800 rounded-lg p-3 text-center shadow-sm">
                    🥬 <div class="font-bold text-sm">الخضار</div>
                    <div class="text-xs">{{ $categories['vegetables'] ?? 0 }} منتج</div>
                </div>
                <div class="flex-1 bg-red-50 border border-red-200 text-red-800 rounded-lg p-3 text-center shadow-sm">
                    🍎 <div class="font-bold text-sm">الفواكة</div>
                    <div class="text-xs">{{ $categories['frutis'] ?? 0 }} منتج</div>
                </div>
            </div>

        </div>

        <div class="bg-gray-50 px-4 py-2 rounded-lg border text-sm text-gray-700 shadow-sm w-full md:w-auto mt-4 md:mt-0">
            👤 <span class="font-semibold">{{ $store->seller->name }}</span><br>
            📞 <span class="text-blue-600">{{ $store->seller->phone_numbers }}</span>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach ($store->products as $index => $product)
        <div
            class="product-card opacity-0 translate-y-6 transition duration-500 delay-[{{ $index * 100 }}ms] bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md overflow-hidden flex flex-col">
            <div class="h-40 bg-gray-100 overflow-hidden">
                <img src="{{ Storage::url($product->images->first()->path ?? 'placeholder.jpg') }}"
                    alt="{{ $product->name }}"
                    class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
            </div>

            <div class="p-4 flex flex-col flex-grow gap-2">
                <h3 class="text-base font-semibold text-gray-800 truncate">{{ $product->name }}</h3>
                <p class="text-sm text-gray-500 line-clamp-2">{{ $product->description }}</p>

                <div class="text-xs text-gray-700 pt-2 border-t space-y-1">
                    <div>💰 <span class="font-medium">السعر:</span> {{ $product->price }} ج</div>
                    <div>🟢 <span class="font-medium">المتوفر:</span> {{ $product->available_quantity }}</div>
                    <div>📦 <span class="font-medium">المباع:</span> {{ $product->sold_quantity }}</div>
                </div>

                <div class="mt-3 flex justify-between items-center gap-2">
                    <a href="{{ route('user.product.show',$product->id) }}"
                        class="flex-1 text-center text-sm bg-blue-600 text-white py-1.5 rounded hover:bg-blue-700 transition">
                        👁️ عرض المنتج
                    </a>


                </div>                    
            </div>
        </div>
        @endforeach
    </div>

</div>

<script>
    window.addEventListener("DOMContentLoaded", () => {
        const storeCard = document.getElementById("store-card");
        storeCard.classList.remove("opacity-0", "translate-y-6");

        document.querySelectorAll(".product-card").forEach((el, i) => {
            setTimeout(() => {
                el.classList.remove("opacity-0", "translate-y-6");
            }, i * 100);
        });
    });
</script>