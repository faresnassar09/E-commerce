<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', ' ')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    </head>
<body class="bg-gray-100">

    @include('layouts.messages')
    @include('users.partials.navbar')

    <div class="flex">
        
        @include('users.partials.sidebar')

        <main class="flex-1 p-4">
            @yield('content')
        </main>
    </div>

</body>  
</html>
