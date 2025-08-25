<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>محاولات كثيرة جدًا</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>


@php
    $key = 'web:' . (request()->input('email') ?? request()->ip());
    $seconds = RateLimiter::availableIn($key);
@endphp

@if ($seconds > 0)
    <p class="text-red-500 font-bold">استنى {{ $seconds }} ثانية قبل المحاولة مرة تانية.</p>
@endif

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-lg rounded-2xl p-8 text-center max-w-md w-full border-t-4 border-red-500 animate-fadeIn">
        <h1 class="text-3xl font-bold text-red-600 mb-4">🚫 تم حظرك مؤقتاً</h1>
        <p class="text-gray-700 text-lg mb-2">لقد قمت بعدد كبير جدًا من المحاولات في وقت قصير.</p>
        <p class="text-gray-600 mb-6">انتظر قليلاً حتى تتمكن من المحاولة مجددًا.</p>

        <div class="bg-gray-100 text-gray-800 p-3 rounded-lg mb-4">
            الرجاء الانتظار <span id="countdown" class="font-bold text-red-600">لدقيقتين قبل المحاولة مره اخري
            </span>
        </div>

        <a href="/" class="inline-block mt-4 text-sm text-blue-600 hover:underline">العودة للصفحة الرئيسية</a>
    </div>


</body>
</html>
