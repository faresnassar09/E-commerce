@vite('resources/css/app.css')
@livewireScripts()
@livewireStyles()

<div class="min-h-screen flex items-start justify-center bg-gray-100 pt-36 px-4">
    <div class="w-full max-w-md bg-white shadow-xl rounded-2xl p-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6 border-b pb-2">📍 إضافة عنوان جديد</h2>

        <form action="{{route('user.insert_address')}}" method="POST" class="space-y-6">
            @csrf

            <!-- Livewire component -->
            <div class="space-y-4">
                <livewire:get-areas />
            </div>

            <!-- زر الحفظ -->
            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition duration-300 border-2 border-blue-800">
                💾 حفظ العنوان
            </button>
        </form>
    </div>
</div>
