@extends('users.partials.app')
@section('title')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.cart_items') }}</title>
    @livewireStyles

</head>
<body>
    
@livewireScripts


<!--  we use livewire to manage cart items and place order -->
  
<livewire:cart-items />

</body>
</html>


@endsection
