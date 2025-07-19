
<div id="mobileSidebar"
     class="sidebar fixed top-0 left-0 w-64 h-screen bg-gray-900 text-white shadow-lg transform transition-transform duration-300 z-50
            -translate-x-full lg:translate-x-0 lg:static lg:block">
    
    <!-- محتوى السايد بار -->
    <ul class="mt-8 space-y-2">

        <li><a href="{{route('seller.dashboard')}}" class="block px-6 py-3 hover:bg-gray-700">🏠 {{__('messages.main_page')}}              </a></li>

        <!-- المنتجات -->
        <li class="dropdown">
            <a href="#" class="toggle-dropdown block px-6 py-3 hover:bg-gray-700">📦 {{__('messages.products')}}</a>
            <ul class="dropdown-menu hidden bg-gray-800 rounded-md w-full">
                <li><a href="{{route('seller.product.create')}}" class="block px-4 py-2 hover:bg-gray-700">🛒 {{__('messages.add_product')}}</a></li>
                <li><a href="{{route('seller.product.index')}}" class="block px-4 py-2 hover:bg-gray-700">📦 {{__('messages.products')}}</a></li>
                <li><a href="{{route('seller.statics.statics')}}" class="block px-4 py-2 hover:bg-gray-700">📊 {{__('messages.statistics')}}</a></li>
            </ul>
        </li>

        <!-- المتاجر -->
        <li class="dropdown">
            <a href="#" class="toggle-dropdown block px-6 py-3 hover:bg-gray-700">🏬 {{__('messages.stores')}}</a>
            <ul class="dropdown-menu hidden bg-gray-800 rounded-md w-full">
                <li><a href="{{route('seller.store.create')}}" class="block px-4 py-2 hover:bg-gray-700">➕ {{__('messages.add_store')}}</a></li>
                <li><a href="{{route('seller.store.index')}}" class="block px-4 py-2 hover:bg-gray-700">📂 {{__('messages.stores')}}</a></li>
                <li><a href="{{route('seller.store.staticses.index')}}" class="block px-4 py-2 hover:bg-gray-700">📊 {{__('messages.statistics')}}</a></li>
            </ul>
        </li>

        <!-- الطلبات -->
        <li class="dropdown">
            <a href="#" class="toggle-dropdown block px-6 py-3 hover:bg-gray-700">🛒 {{__('messages.orders')}}</a>
            <ul class="dropdown-menu hidden bg-gray-800 rounded-md w-full">
                <li><a href="{{route('seller.orders.incoming')}}" class="block px-4 py-2 hover:bg-gray-700">📥 {{__('messages.incoming_orders')}}</a></li>
                <li><a href="{{route('seller.orders.delivered')}}" class="block px-4 py-2 hover:bg-gray-700">✅📦 {{'delivered'}}</a></li>
                <li><a href="{{route('seller.orders.canceled')}}" class="block px-4 py-2 hover:bg-gray-700">❌ {{__('messages.canceled_orders')}}</a></li>
                <li><a href="{{route('seller.orders.return_requests')}}" class="block px-4 py-2 hover:bg-gray-700">🔄 {{__('messages.returns')}}</a></li>
                <!--<li><a href="#" class="block px-4 py-2 hover:bg-gray-700">📊 {{__('messages.statistics')}}</a></li>-->
            </ul>
        </li>
    </ul>

    <!-- الفوترة -->
    <a href="{{route('seller.subscription.get_details')}}" class="block px-6 py-3 hover:bg-gray-700 mt-4">
        🧾 {{ 'الفوترة' }}
    </a>
</div>

<!-- Script Toggle Sidebar + Dropdown -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dropdownToggles = document.querySelectorAll('.toggle-dropdown');
        const dropdownMenus = document.querySelectorAll('.dropdown-menu');
        const sidebar = document.getElementById('mobileSidebar');

        // فتح/غلق القوائم الفرعية
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

        // غلق كل القوائم لما تضغط في أي مكان تاني
        document.addEventListener('click', function () {
            dropdownMenus.forEach(menu => menu.classList.add('hidden'));
        });

        // قفل السايد بار لو المستخدم ضغط على لينك حقيقي (مش اللي بيعمل toggle)
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
