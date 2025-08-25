<!DOCTYPE html>
<html lang="en">
<head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta charset="UTF-8">
    <title>@yield('title', ' ')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    </head>
<body class="bg-gray-100">

    @include('layouts.messages')
    @include('sellers.partials.top-bar')

    <div class="flex">
        
        @include('sellers.partials.side-bar')

        <main class="flex-1 p-4">
            @yield('content')
        </main>
    </div>

</body>  
</html>
