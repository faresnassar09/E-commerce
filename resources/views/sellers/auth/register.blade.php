<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{__('messages.signup_page_title')}}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-md">
        <h2 class="text-xl font-bold text-center text-gray-800 mb-4">{{__('messages.seller_register')}}</h2>

        <form action="{{ route('auth.seller.insert') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
            @csrf
            <div>
                <label for="name" class="block text-gray-700 text-sm font-medium"> {{__('messages.name')}}</label>
                <input type="text" id="name" name="name" required
                class="block mt-1 w-full @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-gray-700 text-sm font-medium">{{__('messages.email')}}</label>
                <input type="email" id="email" name="email" placeholder="example@email.com" required
                class="block mt-1 w-full @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-gray-700 text-sm font-medium">{{__('messages.password')}} </label>
                <input type="password" id="password" name="password"  required
                class="block mt-1 w-full @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-gray-700 text-sm font-medium">{{__('messages.password_confirmation')}} </label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                class="block mt-1 w-full @error('password_confirmation') border-red-500 @enderror">
                @error('password_confirmation')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="phone_numbers" class="block text-gray-700 text-sm font-medium">{{__('messages.phone')}}</label>
                <input type="text" id="phone_numbers" name="phone_numbers" required
                class="block mt-1 w-full @error('phone_numbers') border-red-500 @enderror">
                @error('phone_numbers')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="image" class="block text-gray-700 text-sm font-medium">{{__('messages.avatar')}}</label>
                <input type="file" id="image" name="image"
                    class="w-full p-1 border rounded-md text-sm @error('image') border-red-500 @enderror">
                @error('image')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button type="submit" class="w-full bg-indigo-600 text-white p-2 text-sm rounded-md hover:bg-indigo-700">{{__('messages.signup_button')}}</button>
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