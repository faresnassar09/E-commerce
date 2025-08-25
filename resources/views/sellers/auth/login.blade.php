<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{__('messages.login_page_title') }} </title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-sm">
        <h2 class="text-xl font-bold text-center text-gray-800 mb-4">{{__('messages.sign_in')}}</h2>

        <form action="{{ route('auth.seller.login.submit') }}" method="POST" class="space-y-3">
            @csrf
            <div>
                <label for="email" class="block text-gray-700 text-sm font-medium"> {{ __('messages.email')}}</label>
                <input type="email" id="email" name="email" placeholder="example@email.com" required
                    class="w-full p-1 border rounded-md text-sm @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-gray-700 text-sm font-medium">{{__('messages.password')}}</label>
                <input type="password" id="password" name="password"  required
                    class="w-full p-1 border rounded-md text-sm @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            @if(session('login_failed'))
                <div class="text-red-500 text-xs text-center font-bold mt-2">
                    {{ session('login_failed') }}
                </div>
            @endif

            <div>
                <button type="submit" class="w-full bg-indigo-600 text-white p-2 text-sm rounded-md hover:bg-indigo-700">{{__('messages.login_button')}}</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(() => {
                document.querySelectorAll(".text-red-500").forEach(el => el.style.display = "none");
            }, 5000);
        });
    </script>
</body>
</html>