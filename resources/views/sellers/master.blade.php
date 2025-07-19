<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Default Title')</title>
    <!-- <link rel="stylesheet" href="{{ asset('css/sellers/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sellers/partials/side-bar.css') }}"> -->
    <!-- <link rel="stylesheet" href="{{ asset('css/sellers/partials/top-bar.css') }}"> -->

</head>
<body>
@include('layouts.messages')
  
    <!-- Sidebar -->
    @include('sellers.partials.side-bar')

    <!-- Main Content -->
        @include('sellers.partials.top-bar') <!-- توب بار -->
         
           @yield('content') <!-- محتوى الصفحة -->
  
    </div>
</body>
</html>
