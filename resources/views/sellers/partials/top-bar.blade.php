

<div class="topbar flex items-center justify-between bg-gray-900 text-white px-6 py-3 shadow-md relative">
    <!-- Logo & Profile Dropdown -->
    
            <div class="md:hidden" id='test'>
            <button onclick="document.getElementById('mobileSidebar').classList.toggle('hidden')">
                <i class="fas fa-bars text-2xl"> القائمة ☰</i>
            </button>
        </div>
    <div class="relative">
        <div id="profileImage" class="image-frame w-12 h-12 rounded-full overflow-hidden cursor-pointer border-2 border-white hover:border-gray-400">
            <img src="{{ asset('images/'.auth()->guard('seller')->user()?->profile_picture) }}" alt="User Image" class="w-full h-full object-cover">
        </div>
        

        <!-- قائمة الملف الشخصي -->
        <ul id="profileDropdown" class="dropdown-menu absolute hidden bg-white text-gray-900 right-[-150px] mt-2 min-w-[200px] shadow-lg rounded-md py-2 z-50 transition-all duration-300 transform translate-y-2 opacity-0">
            <h6 class="admin_mail px-4 py-2 text-sm font-semibold border-b">{{ auth()->guard('seller')->user()->email }}</h6>
            <li><a href="{{ route('seller.profile.index') }}" class="block px-4 py-2 hover:bg-blue-100">👤 {{__('messages.profile')}}</a></li>
            <!-- <li><a href="#" class="block px-4 py-2 hover:bg-blue-100">⚙️ الإعدادات</a></li>
            <li><a href="#" class="block px-4 py-2 hover:bg-blue-100">📞 الدعم</a></li> --> 
        </ul>
    </div>
    
    


<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('mobileSidebar');
        sidebar.classList.toggle('hidden');
    }

    window.addEventListener('DOMContentLoaded', () => {
        const sidebar = document.getElementById('mobileSidebar');
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



    <!-- Navigation Links -->
    <div class="nav-links hidden md:flex gap-6 text-lg">
        <a href="#" class="hover:text-blue-400">🏠 {{__('messages.main_page')}}</a>
        <a href="#" class="hover:text-blue-400">📌 من نحن</a>
        <a href="#" class="hover:text-blue-400">🚀 الخدمات</a>
        <a href="#" class="hover:text-blue-400">📞 اتصل بنا</a>
    </div>
    
    <!-- User Info & Notifications -->
    <div class="user-info flex items-center gap-4">
        <!-- Welcome Message -->
        <span class="text-sm font-semibold">👋 {{ __('messages.welcome') }} {{ auth()->guard('seller')->user()->name }}</span>

        <!-- أيقونة الجرس -->

<!-- أيقونة الجرس مع شارة عدد الإشعارات -->
<div id="notificationBell" class="relative cursor-pointer text-2xl">
    🔔
    <!-- شارة الإشعارات -->
    
  
    <span id="notificationBadge" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full 
        {{ AuthSeller::fullInfo()->unreadnotifications()->count() > 0 ? '' : 'hidden' }}">
        {{ AuthSeller::fullInfo()->unreadnotifications()->count() }}
    </span>
</div>


<ul id="notificationDropdown"
    class="dropdown-menu absolute hidden bg-white text-gray-900 right-4 top-full mt-3 min-w-[280px] shadow-lg rounded-lg py-2 z-50 transition-all duration-300 transform opacity-0 border border-gray-200">

    <h6 class="px-4 py-2 text-sm font-semibold border-b bg-gray-100 sticky top-0 z-10">
        🔔 {{ __('messages.notifications') }}
    </h6>

    @foreach (AuthSeller::fullInfo()->unreadnotifications()->get() as $notification)

    <!-- إشعار -->
    <li class="px-4 py-3 border-b last:border-b-0 hover:bg-gray-50 transition cursor-pointer">
        <div class="font-semibold text-gray-800 text-sm">
          {{$notification->data['title']}}
        </div>
        <div class="text-gray-500 text-xs mt-1">
{{ $notification->created_at->format('Y:m:d:  الساعهh') }}<br>
{{ $notification->data['content'] }}
    </div>
    </li>
@endforeach
    <!-- عرض الكل -->
    <li class="text-center px-4 py-2 text-blue-500 hover:bg-blue-100 text-sm font-medium cursor-pointer">
        عرض الكل
    </li>
</ul>


        <!-- Logout Button -->
        <form method="POST" action="{{ route('auth.seller.logout') }}">
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md text-sm">🚪 {{ __('messages.logout') }} </button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const notificationBell = document.getElementById('notificationBell');
    const notificationDropdown = document.getElementById('notificationDropdown');

    // فتح القائمة عند الضغط على الجرس
    notificationBell.addEventListener('click', function(event) {
        event.stopPropagation();
        notificationDropdown.classList.toggle('hidden');
        notificationDropdown.classList.toggle('translate-y-0');
        notificationDropdown.classList.toggle('opacity-100');
    });
       profileImage.addEventListener('click', function(event) {
            event.stopPropagation();
            profileDropdown.classList.toggle('hidden');
            profileDropdown.classList.toggle('translate-y-0');
            profileDropdown.classList.toggle('opacity-100');
        });
        // إغلاق القوائم عند النقر خارجها
        document.addEventListener('click', function(event) {
            if (!profileDropdown.contains(event.target) && !profileImage.contains(event.target)) {
                profileDropdown.classList.add('hidden');
                profileDropdown.classList.remove('translate-y-0', 'opacity-100');
            }
            if (!notificationDropdown.contains(event.target) && !notificationBell.contains(event.target)) {
                notificationDropdown.classList.add('hidden');
                notificationDropdown.classList.remove('translate-y-0', 'opacity-100');
            }
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleButton = document.getElementById('toggleSidebarBtn');
        const sidebar = document.getElementById('mobileSidebar');

        toggleButton.addEventListener('click', function () {
            sidebar.classList.toggle('-translate-x-full');
        });
    });
</script>
