<meta name="viewport" content="width=device-width, initial-scale=1.0">

@vite('resources/css/app.css')

<div class="flex" >
    <aside id="side" class="w-64 bg-gray-800 text-white min-h-screen p-4">

        <h2 class="text-xl font-bold mb-6">{{__('messages.list')}}</h2>
        <ul class="space-y-4">
            <li><a href="{{route('user.profile.edit')}}"   class="block hover:text-yellow-400">👤 {{__('messages.profile')}}</a></li>


            <li class="relative">
    <button type="button" class="toggle-dropdown w-full text-left px-4 py-2 hover:text-yellow-400 flex items-center">
    📦 {{ __('messages.orders') }}
    </button>
    <ul class="dropdown-menu hidden bg-gray-800 text-white shadow-md rounded-md mt-1 w-full">
        <li><a href="{{ route('user.orders.delivered') }}" class="block px-4 py-2 hover:bg-gray-700">✅ {{ __('messages.delivered_orders') }}</a></li>
        <li><a href="{{ route('user.orders.index') }}" class="block px-4 py-2 hover:bg-gray-700">📥 {{ __('messages.current_orders') }}</a></li>
        <li><a href="{{ route('user.orders.cancelled') }}" class="block px-4 py-2 hover:bg-gray-700">❌ {{ __('messages.canceled_orders') }}</a></li>
        <li><a href="{{ route('user.orders.get_returns') }}" class="block px-4 py-2 hover:bg-gray-700">🔄 {{ __('messages.returns') }}</a></li>
    </ul>
</li>


            <li><a href="{{route('user.cart.index')}}" class="block hover:text-yellow-400">🛒 {{__('messages.cart_items')}}</a></li>
            <li>
                <form method="POST" action="{{route('logout')}}">
                @csrf

                    <button type="submit" class="w-full text-left hover:text-yellow-400">🚪 {{__('messages.logout')}}</button>
                </form>
            </li>
        </ul>
<br>
        @include('layouts.change-language')

    </aside>

    <div class="flex-1 p-6">
    </div>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dropdownToggles = document.querySelectorAll('.toggle-dropdown');
        const dropdownMenus = document.querySelectorAll('.dropdown-menu');

        dropdownToggles.forEach(toggle => {
            toggle.addEventListener('click', function (event) {
                event.stopPropagation(); 
                dropdownMenus.forEach(menu => {
                    if (menu !== this.nextElementSibling) {
                        menu.classList.add('hidden');
                    }
                });

                this.nextElementSibling.classList.toggle('hidden');
            });
        });

        document.addEventListener('click', function () {
            dropdownMenus.forEach(menu => {
                menu.classList.add('hidden');
            });
        });
    });
</script>