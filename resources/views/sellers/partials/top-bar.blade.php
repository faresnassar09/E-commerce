<div class="topbar flex items-center justify-between bg-gray-900 text-white px-6 py-3 shadow-md relative">


    <div class="md:hidden" id='test'>
        <button onclick="document.getElementById('mobileSidebar').classList.toggle('hidden')">
            <i class="fas fa-bars text-2xl"> {{__('messages.menu')}} ☰</i>
        </button>
    </div>
    <div class="relative">
        <div id="profileImage" class="image-frame w-12 h-12 rounded-full overflow-hidden cursor-pointer border-2 border-white hover:border-gray-400">
            <img src="{{ Storage::url(auth()->guard('seller')->user()?->profile_picture) }}" alt="User Image" class="w-full h-full object-cover">
        </div>

        <ul id="profileDropdown" class="dropdown-menu absolute hidden bg-white text-gray-900 right-[-150px] mt-2 min-w-[200px] shadow-lg rounded-md py-2 z-50 transition-all duration-300 transform translate-y-2 opacity-0">
            <h6 class="admin_mail px-4 py-2 text-sm font-semibold border-b">{{ auth()->guard('seller')->user()->email }}</h6>
            <li><a href="{{ route('seller.profile.index') }}" class="block px-4 py-2 hover:bg-blue-100">👤 {{__('messages.profile')}}</a></li>
        </ul>
    </div>

    <div class="user-info flex items-center gap-4">
        <span class="text-sm font-semibold">👋 {{ __('messages.welcome') }} {{ auth()->guard('seller')->user()->name }}</span>

        <div id="notificationBell" class="relative cursor-pointer text-2xl">
            🔔
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
            <li class="px-4 py-3 border-b last:border-b-0 hover:bg-gray-50 transition cursor-pointer">
                <div class="font-semibold text-gray-800 text-sm">
                    {{$notification->data['title']}}
                </div>
                <div class="text-gray-500 text-xs mt-1">
                    {{ $notification->created_at->format('Y-m-d H:i') }}<br>
                    {{ $notification->data['content'] }}
                </div>
            </li>
            @endforeach
            <li class="text-center px-4 py-2 text-blue-500 hover:bg-blue-100 text-sm font-medium cursor-pointer">
                {{__('messages.view_all')}}
            </li>
        </ul>

        <form method="POST" action="{{ route('auth.seller.logout') }}">
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md text-sm">🚪 {{ __('messages.logout') }} </button>
        </form>

@include('layouts.change-language')

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const notificationBell = document.getElementById('notificationBell');
        const notificationDropdown = document.getElementById('notificationDropdown');
        const profileImage = document.getElementById('profileImage');
        const profileDropdown = document.getElementById('profileDropdown');

        notificationBell.addEventListener('click', function(event) {
            event.stopPropagation();
            notificationDropdown.classList.toggle('hidden');
            notificationDropdown.classList.toggle('translate-y-0');
            notificationDropdown.classList.toggle('opacity-100');
            profileDropdown.classList.add('hidden');
            profileDropdown.classList.remove('translate-y-0', 'opacity-100');
        });

        profileImage.addEventListener('click', function(event) {
            event.stopPropagation();
            profileDropdown.classList.toggle('hidden');
            profileDropdown.classList.toggle('translate-y-0');
            profileDropdown.classList.toggle('opacity-100');

            notificationDropdown.classList.add('hidden');
            notificationDropdown.classList.remove('translate-y-0', 'opacity-100');
        });

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

    document.addEventListener('DOMContentLoaded', function () {
        const toggleButton = document.getElementById('test');
        const sidebar = document.getElementById('mobileSidebar');

        toggleButton.addEventListener('click', function () {
            sidebar.classList.toggle('-translate-x-full');
            sidebar.classList.toggle('hidden', sidebar.classList.contains('-translate-x-full'));
        });
    });
</script>
