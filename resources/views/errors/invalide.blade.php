
@vite('resources/css/app.css')

<div class="min-h-screen flex items-center justify-center bg-gray-100 p-4">
    <div class="bg-white shadow-xl rounded-2xl p-8 max-w-md w-full text-center space-y-6 border border-red-300">
        <h1 class="text-2xl font-bold text-red-600">Access Denied</h1>
        <p class="text-gray-700">
            You have been <span class="font-semibold">banned</span> by the administrator.
        </p>
        <p class="text-gray-600 text-sm">
            You can file a complaint by clicking the button below or contact us directly via WhatsApp or email.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            @if(auth()->guard('seller')->user())
            <a href="{{ route('support.complaint.tickets') }}"
               class="bg-blue-600 text-white px-5 py-2 rounded-xl hover:bg-blue-700 transition">
               File a Complaint
            </a>
            @endif

            <a href="https://wa.me/201555590036" target="_blank"
               class="bg-green-600 text-white px-5 py-2 rounded-xl hover:bg-green-700 transition">
               Contact via WhatsApp
            </a>
        </div>
  
        <p class="text-gray-500 text-sm">
            Or send us an email at <a href="mailto:fares.ahmed.nassar0@gmail.com" class="text-blue-500 underline">fares.ahmed.nassar0@gmail.com</a>
        </p>
    </div>
</div>
