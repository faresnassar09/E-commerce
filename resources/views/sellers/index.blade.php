<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.seller_section_title') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background: radial-gradient(ellipse at bottom, #0f2027 0%, #203a43 40%, #2c5364 100%);
            overflow: hidden;
            color: #fff;
        }
        .stars {
            position: absolute;
            width: 100%;
            height: 100%;
            background: transparent url('https://raw.githubusercontent.com/VincentGarreau/particles.js/master/demo/media/stars.png') repeat;
            z-index: 0;
            animation: moveStars 200s linear infinite;
        }
        @keyframes moveStars {
            from { background-position: 0 0; }
            to { background-position: -10000px 5000px; }
        }
        .glow {
            text-shadow: 0 0 10px #0ff, 0 0 20px #0ff, 0 0 40px #0ff;
        }
        .neon-box {
            border: 2px solid #0ff;
            box-shadow: 0 0 10px #0ff, 0 0 30px #0ff;
            background: rgba(0, 0, 0, 0.4);
        }
        .btn-glitch {
            position: relative;
            overflow: hidden;
        }
        .btn-glitch::before, .btn-glitch::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: inherit;
            z-index: -1;
            mix-blend-mode: screen;
            animation: glitch 2s infinite;
        }
        .btn-glitch::after {
            animation-delay: 0.2s;
        }
        @keyframes glitch {
            0% { transform: translate(0, 0); }
            20% { transform: translate(-2px, 2px); }
            40% { transform: translate(2px, -2px); }
            60% { transform: translate(-1px, 1px); }
            80% { transform: translate(1px, -1px); }
            100% { transform: translate(0, 0); }
        }
    </style>
</head>
<body>
    <div class="stars"></div>

    <main class="flex items-center justify-center min-h-screen relative z-10 px-4">
        <div class="neon-box rounded-3xl p-10 max-w-lg w-full text-center space-y-6 animate-fade-in">
            <h2 class="text-4xl font-extrabold glow">{{ __('messages.welcome_seller_section') }} 👽</h2>

            <p class="text-gray-300 text-base">
                {{ __('messages.seller_motto_1') }} 🛸 <br>
                {{ __('messages.seller_motto_2') }} 🌌
            </p>

            <p class="text-gray-300 text-base">
                {{ __('messages.seller_promise') }} 🚀
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center pt-4">
                <a href="{{ route('auth.seller.login.submit') }}" class="px-6 py-2 bg-cyan-500 hover:bg-cyan-600 text-white font-semibold rounded-full btn-glitch transition duration-200">
                    {{ __('messages.login') }}
                </a>
                <a href="{{ route('auth.seller.create') }}" class="px-6 py-2 bg-white text-gray-800 hover:bg-gray-100 font-semibold rounded-full btn-glitch transition duration-200">
                    {{ __('messages.create_account') }}
                </a>
            </div>
        </div>
    </main>
</body>
</html>