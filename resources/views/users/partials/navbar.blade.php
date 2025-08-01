
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<nav class="bg-gray-900 text-white">
    
    <div class="container mx-auto px-4 py-4 flex justify-between items-center flex-wrap gap-y-4">
        
           


<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('side');
        sidebar.classList.toggle('hidden');
    }

    window.addEventListener('DOMContentLoaded', () => {
        const sidebar = document.getElementById('side');
        const links = sidebar.querySelectorAll('a');

        // تأكد إنه مغلق في البداية
        sidebar.classList.add('hidden');

        // يقفل لما تدوس بره السايدبار
        document.addEventListener('click', (e) => {
            const isClickInside = sidebar.contains(e.target);
            const toggleButton = document.getElementById('test');

            if (!isClickInside && !toggleButton.contains(e.target)) {
                sidebar.classList.add('hidden');
            }
        });
    });
</script>

@if(auth()->user())
            <div   id='test'>
            <button onclick="document.getElementById('side').classList.toggle('hidden')">
                <i class="fas fa-bars text-2xl"> القائمة ☰</i>
            </button>
        </div>
        @endif
        
        <!-- Logo -->
        <div class="flex items-center gap-x-4">
            <img src="https://via.placeholder.com/40" alt="Logo" class="w-10 h-10">
            <a href="{{ route('index') }}" class="text-2xl font-bold text-orange-500">g</a>
        </div>

        <!-- Hamburger Menu (Mobile) -->
        @if(!auth()->user())
        <div class="md:hidden">
            <button onclick="document.getElementById('mobileMenu').classList.toggle('hidden')">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>
        @endif
        
            <script>
        const sidebar = document.getElementById('mobileSidebar');
        const toggleBtn = document.getElementById('toggleSidebarBtn');

        function toggleSidebar() {
            sidebar.classList.toggle('hidden');
        }

        function handleClickOutside(event) {
            const isClickInsideSidebar = sidebar.contains(event.target);
            const isClickOnToggleBtn = toggleBtn.contains(event.target);

            if (!isClickInsideSidebar && !isClickOnToggleBtn) {
                // لو دوس برا السايدبار
                sidebar.classList.add('hidden');
            }

            if (event.target.tagName === 'A' && sidebar.contains(event.target)) {
                // لو دوس على لينك داخل السايدبار
                sidebar.classList.add('hidden');
            }
        }
    </script>

        <!-- Menu (Desktop) -->
        <div class="hidden md:flex items-center gap-12">
            <a href="{{ route('index') }}" class="hover:text-gray-400 flex ">
                <i class="fas fa-home mr-2"></i> {{ __('messages.main_page') }}
            </a>
            <a href="{{route('seller.landing')}}" class="hover:text-gray-400 flex items-center">
                <i class="fas fa-th-large mr-2"></i> {{'Seller Section'}}
            </a>
            <a href="#" class="hover:text-gray-400 flex items-center">
                <i class="fas fa-gift mr-2"></i> {{ __('messages.offers') }}
            </a>
            <a href="#" class="hover:text-gray-400 flex items-center">
                <i class="fas fa-phone-alt mr-2"></i> {{ __('messages.contact') }}
            </a>
            

        </div>
        

        <!-- Auth Buttons (Desktop) -->
        <div class="hidden md:flex items-center gap-x-6">
            @guest
<div class="flex space-x-3 ">
    <a href="{{ route('login') }}" class="bg-orange-500 px-4 py-2 rounded hover:bg-orange-600 transition">
        <i class="fas fa-sign-in-alt mr-1"></i> {{ __('messages.login') }}
    </a>
    <a href="{{ route('register') }}" class="border-2 border-orange-500 text-orange-500 px-4 py-2 rounded hover:bg-orange-500 hover:text-white transition">
        <i class="fas fa-user-plus mr-1"></i> {{ __('messages.signup') }}
    </a>
</div>
            @else
                <a href="{{ route('user.cart.index') }}" class="relative text-white hover:text-red-100 text-lg flex flex-col items-center">
                    <span class="relative">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="absolute -top-3 -right-2 bg-red-600 text-xs font-bold px-2 py-0.5 rounded-full">
                            {{ auth()->user()->cartItems()->count() ?? 0 }}
                        </span>
                    </span>
                    <span class="text-xs">{{ __('messages.cart_items') }}</span>
                </a>

                @if (!request()->routeIs('user.dashboard'))
                    <a href="{{ route('user.orders.index') }}" class="relative text-white hover:text-orange-400 text-lg flex flex-col items-center">
                        <span class="relative">
                            <i class="fas fa-receipt"></i>
                            <span class="absolute -top-3 -right-2 bg-orange-500 text-xs font-bold px-2 py-0.5 rounded-full">
                                {{ auth()->user()->orders()->where('status',0)->count() ?? 0 }}
                            </span>
                        </span>
                        <span class="text-xs">{{ __('messages.orders') }}</span>
                    </a>
                @endif

                <a href="{{ route('user.dashboard') }}" class="border-2 border-orange-500 text-orange-500 px-4 py-2 rounded hover:bg-orange-500 hover:text-white transition flex items-center">
                    <i class="fas fa-user mr-2"></i> {{ __('messages.profile') }}
                </a>
            @endguest
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="md:hidden hidden px-4 pb-4 space-y-4">


        @guest
            <a href="{{ route('login') }}" class="block text-white hover:text-orange-400">
                <i class="fas fa-sign-in-alt mr-2"></i> {{ __('messages.login') }}
            </a>
            <a href="{{ route('register') }}" class="block text-white hover:text-orange-400">
                <i class="fas fa-user-plus mr-2"></i> {{ __('messages.signup') }}
            </a>
        @else
            <a href="{{ route('user.cart.index') }}" class="block text-white hover:text-orange-400">
                <i class="fas fa-shopping-cart mr-2"></i> {{ __('messages.cart_items') }}
            </a>
            @if (!request()->routeIs('user.dashboard'))
                <a href="{{ route('user.orders.index') }}" class="block text-white hover:text-orange-400">
                    <i class="fas fa-receipt mr-2"></i> {{ __('messages.orders') }}
                </a>
            @endif
            <a href="{{ route('user.profile.edit') }}" class="block text-white hover:text-orange-400">
                <i class="fas fa-user mr-2"></i> {{ __('messages.profile') }}
            </a>
        @endguest
    </div>

    <!-- Address Modal -->
    <div id="addressModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex justify-center items-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">

        </div>
    </div>
</nav>
