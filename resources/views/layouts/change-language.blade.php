<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="//unpkg.com/alpinejs" defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flag-icons/css/flag-icons.min.css">

</head>
<body>
  <div x-data="{ open: false }" class="relative w-full sm:w-auto order-last sm:order-first">
                <button @click="open = !open" type="button" class="inline-flex items-center gap-x-1 text-sm font-medium text-white-500 hover:text-blue-600 transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded-md py-2 px-3 w-full justify-center sm:justify-start">
                    <span class="fi fi-{{ app()->getLocale() === 'ar' ? 'sa' : 'us' }} rounded-full mr-2"></span> {{ app()->getLocale() === 'ar' ? 'العربية' : 'English' }}
                    <svg class="-mr-1 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                    </svg>
                </button>

                <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute z-10 mt-2 w-32 sm:w-auto origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none {{ app()->getLocale() === 'ar' ? 'sm:right-0' : 'sm:left-0' }}"> {{-- تعديل لـ left/right بناءً على الاتجاه --}}
                    <div class="py-1" role="none">
                        <a href="{{ route('lang.switch','ar') }}" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100" role="menuitem" tabindex="-1" id="menu-item-0">
                            <span class="fi fi-sa rounded-full mr-2"></span> العربية
                        </a>
                        <a href="{{ route('lang.switch','en') }}" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100" role="menuitem" tabindex="-1" id="menu-item-1">
                            <span class="fi fi-us rounded-full mr-2"></span> English
                        </a>
                    </div>
                </div>
            </div>  
</body>
</html>
