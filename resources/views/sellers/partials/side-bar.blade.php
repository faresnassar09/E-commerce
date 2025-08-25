<div id="mobileSidebar"
     class="sidebar fixed top-0 left-0 w-64 h-screen bg-gray-900 text-white shadow-lg transform transition-transform duration-300 z-50
            -translate-x-full lg:translate-x-0 lg:static lg:block">

    <ul class="mt-8 space-y-2">

        <li><a href="{{route('seller.dashboard')}}" class="block px-6 py-3 hover:bg-gray-700">🏠 {{__('messages.main_page')}}</a></li>

        <li class="dropdown">
            <a href="#" class="toggle-dropdown block px-6 py-3 hover:bg-gray-700">📦 {{__('messages.products')}}</a>
            <ul class="dropdown-menu hidden bg-gray-800 rounded-md w-full">
                <li><a href="{{route('seller.product.create')}}" class="block px-4 py-2 hover:bg-gray-700">🛒 {{__('messages.add_product')}}</a></li>
                <li><a href="{{route('seller.product.index')}}" class="block px-4 py-2 hover:bg-gray-700">📦 {{__('messages.all_products')}}</a></li>
                <li><a href="{{route('seller.statics.statics')}}" class="block px-4 py-2 hover:bg-gray-700">📊 {{__('messages.statistics')}}</a></li>
            </ul>
        </li>

        <li class="dropdown">
            <a href="#" class="toggle-dropdown block px-6 py-3 hover:bg-gray-700">🏬 {{__('messages.stores')}}</a>
            <ul class="dropdown-menu hidden bg-gray-800 rounded-md w-full">
                <li><a href="{{route('seller.store.create')}}" class="block px-4 py-2 hover:bg-gray-700">➕ {{__('messages.add_store')}}</a></li>
                <li><a href="{{route('seller.store.index')}}" class="block px-4 py-2 hover:bg-gray-700">📂 {{__('messages.all_stores')}}</a></li>
                <li><a href="{{route('seller.store.staticses.index')}}" class="block px-4 py-2 hover:bg-gray-700">📊 {{__('messages.statistics')}}</a></li>
            </ul>
        </li>

        <li class="dropdown">
            <a href="#" class="toggle-dropdown block px-6 py-3 hover:bg-gray-700">🛒 {{__('messages.orders')}}</a>
            <ul class="dropdown-menu hidden bg-gray-800 rounded-md w-full">
                <li><a href="{{route('seller.orders.incoming')}}" class="block px-4 py-2 hover:bg-gray-700">📥 {{__('messages.incoming_orders')}}</a></li>
                <li><a href="{{route('seller.orders.delivered')}}" class="block px-4 py-2 hover:bg-gray-700">✅📦 {{__('messages.delivered_orders')}}</a></li>
                <li><a href="{{route('seller.orders.canceled')}}" class="block px-4 py-2 hover:bg-gray-700">❌ {{__('messages.canceled_orders')}}</a></li>
                <li><a href="{{route('seller.orders.return_requests')}}" class="block px-4 py-2 hover:bg-gray-700">🔄 {{__('messages.returns')}}</a></li>
            </ul>
        </li>
    </ul>

    <a href="{{route('seller.profile.index')}}" class="block px-6 py-3 hover:bg-gray-700 mt-4">
        {{__('messages.profile')}}
    </a>
    <a href="{{route('seller.subscription.get_details')}}" class="block px-6 py-3 hover:bg-gray-700 mt-4">
        🧾 {{__('messages.billing')}}
    </a>

    <a href="{{route('support.complaint.tickets')}}" class="block px-6 py-3 hover:bg-gray-700 mt-4">
        {{__('messages.complaints')}}
    </a>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dropdownToggles = document.querySelectorAll('.toggle-dropdown');
        const dropdownMenus = document.querySelectorAll('.dropdown-menu');
        const sidebar = document.getElementById('mobileSidebar');

        dropdownToggles.forEach(toggle => {
            toggle.addEventListener('click', function (event) {
                event.preventDefault();
                event.stopPropagation();

                const menu = this.nextElementSibling;

                dropdownMenus.forEach(m => {
                    if (m !== menu) m.classList.add('hidden');
                });

                menu.classList.toggle('hidden');
            });
        });

        document.addEventListener('click', function () {
            dropdownMenus.forEach(menu => menu.classList.add('hidden'));
        });

        const allLinks = sidebar.querySelectorAll('a:not(.toggle-dropdown)');

        allLinks.forEach(link => {
            link.addEventListener('click', function () {
                if (window.innerWidth < 1024) {
                    sidebar.classList.add('-translate-x-full');
                }
            });
        });
    });
</script>


</body>