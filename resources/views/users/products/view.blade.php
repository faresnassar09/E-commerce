<script src="https://cdn.tailwindcss.com"></script>
@livewireStyles
@livewireScripts

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product['name'] }}</title>

    <style>
        .slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }
        .slide.active {
            opacity: 1;
        }
.arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    font-size: 32px; 
    cursor: pointer;
    user-select: none;
    color: white;
    z-index: 50; 
    padding: 15px; 
    background: rgba(0,0,0,0.3); 
    border-radius: 50%;
    pointer-events: auto; 
}

.prev { left: 10px; }
.next { right: 10px; }

    </style>
</head>

<body class="bg-gray-100 font-sans">

<div id="slideshow-container" class="relative w-full md:w-[80%] lg:w-[60%] h-[300px] sm:h-[400px] mx-auto mt-6 overflow-hidden rounded-lg bg-black">
    @foreach ($product->images as $index => $image)
        <div class="slide {{ $index === 0 ? 'active' : '' }}">
            <img src="{{ Storage::url($image->path) }}" alt="Product Image" class="w-full h-full object-cover">
        </div>
    @endforeach

    <span class="arrow prev" onclick="changeSlide(-1)">&#10094;</span>
    <span class="arrow next" onclick="changeSlide(1)">&#10095;</span>
</div>

<div class="bg-white mt-6 rounded-lg shadow p-6 w-[95%] md:w-[85%] lg:w-[70%] mx-auto">

    <div class="mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold mb-3 text-blue-600 text-right">{{ $product['name'] }}</h1>
        <p class="text-gray-700 text-md sm:text-lg text-right">{{ $product['description'] }}</p>
    </div>

    <div class="flex flex-col md:flex-row-reverse gap-6">
        <div class="md:w-1/2">
            <p class="font-semibold text-lg mb-2">🏬 {{ __('messages.store_info') }}:</p>
            <p>{{ __('messages.store_name') }}: <span class="font-semibold">{{ $product['store']['name'] }}</span></p>
            <p>{{ __('messages.city') }}: {{ $product?->store->city_name }}</p>
            <p>{{ __('messages.area') }}: {{ $product?->store->area_name }}</p>
            <p>{{ __('messages.street') }}: {{ $product?->store->street }}</p>
        </div>
    @if (!auth()->guard('seller')->user())
        <div class="text-white text-xl py-3 px-6 mb-4 rounded-full transition ease-in-out duration-300">
            <livewire:add-to-cart :id="$product['id']" />
        </div>
    @endif

        <div class="md:w-1/2">
            <p class="text-lg font-semibold mb-2">💰 {{ __('messages.price') }}: <span class="text-green-600">{{ $product['price'] }} {{ __('messages.aed') }}</span></p>
            @if($product['discount'] > 0)
                <p class="text-lg font-semibold text-red-500">
                    🔻 {{ __('messages.discount') }}: <span class="line-through text-gray-500">{{ $product['price'] }}</span>
                    {{ __('messages.now_at') }} {{ $product['price'] - $product['discount'] }} {{ __('messages.aed') }}
                </p>
            @endif
            <p class="text-md mt-2">📦 {{ __('messages.available_quantity') }}: <strong>{{ $product['available_quantity'] }}</strong></p>
            <p class="text-md">🛒 {{ __('messages.sold_quantity') }}: <strong>{{ $product['sold_quantity'] }}</strong></p>
        </div>
    </div>
</div>

<script>
let slideIndex = 0;
const slides = document.querySelectorAll('.slide');
const numSlides = slides.length;

if (numSlides <= 1) {
    document.querySelectorAll('.arrow').forEach(arrow => arrow.style.display = 'none');
}

function showSlide(n) {
    slideIndex = (n + numSlides) % numSlides;
    slides.forEach(slide => slide.classList.remove('active'));
    slides[slideIndex].classList.add('active');
}

function changeSlide(n) {
    showSlide(slideIndex + n);
}

// تحريك بالكيبورد
document.addEventListener('keydown', function (event) {
    if (event.key === 'ArrowLeft') {
        changeSlide(-1);
    } else if (event.key === 'ArrowRight') {
        changeSlide(1);
    }
});

let startX = 0;
let startY = 0;
let endX = 0;
let endY = 0;

const slider = document.getElementById('slideshow-container');

slider.addEventListener('touchstart', function (e) {
    startX = e.touches[0].clientX;
    startY = e.touches[0].clientY;
}, { passive: true });

slider.addEventListener('touchend', function (e) {
    endX = e.changedTouches[0].clientX;
    endY = e.changedTouches[0].clientY;

    let diffX = startX - endX;
    let diffY = startY - endY;

    if (Math.abs(diffX) > Math.abs(diffY)) {
        if (diffX > 50) { 
            changeSlide(1);
        } else if (diffX < -50) { 
            changeSlide(-1);
        }
    }
}, { passive: true });

showSlide(slideIndex);

</script>


<script src="https://unpkg.com/alpinejs" defer></script>

</body>
</html>