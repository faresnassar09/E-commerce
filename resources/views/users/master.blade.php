<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','user')</title>
</head>
<body>
@include('users.partials.navbar')
@include('users.partials.sidebar')

@yield('content')

@include('users.partials.fotter')

</body>
</html>