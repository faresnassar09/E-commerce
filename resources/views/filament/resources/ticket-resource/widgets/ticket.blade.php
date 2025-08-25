<x-filament-widgets::widget>
    <x-filament::section>

        {{-- ✅ صور الشكوى نفسها --}}
        <div class="mb-50 pb-4 border-b border-gray-300">
    <h3 class="text-md font-semibold text-gray-800 mb-3">📎 صور الشكوى</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach ($this->ticketImages() as  $image)
            <a target="_blank" href="{{ Storage::url($image->path) }}">
                <img src="{{ Storage::url($image->path) }}"
                     class="w-full h-32 object-cover rounded shadow border hover:scale-105 transition-transform duration-200">
            </a>
        @endforeach
    </div>
</div>


        {{-- ✅ الردود --}}
        <div class="space-y-4">
            @foreach ($this->getReplies() as $reply)
                <div class="border border-gray-300 p-4 rounded-lg bg-white shadow-sm">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-600">
                            {{ $reply->sender_type === 'admin' ? '🛡️ Admin' : '🧑‍💼 Seller' }}
                        </span>
                        <span class="text-xs text-gray-600">
                            {{ $reply->created_at->diffForHumans() }}
                        </span>
                    </div>

                    <div class="text-gray-700 mb-2">
                        {{ $reply->message }}
                    </div>

                    @if($reply->images && $reply->images->count())
                        <div class="flex flex-wrap gap-2 mt-2">
                            @foreach($reply->images as $image)
                                <a href="{{ Storage::url($image->path) }}" target="_blank">
                                    <img src="{{ Storage::url($image->path) }}"
                                         class="w-24 h-24 object-cover rounded border border-gray-200 shadow hover:scale-105 transition-transform duration-200">
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach

            @if($this->getReplies()->isEmpty())
                <div class="text-gray-500 text-sm italic text-center">
                    لا توجد ردود حتى الآن.
                </div>
            @endif
        </div>

    </x-filament::section>
</x-filament-widgets::widget>
