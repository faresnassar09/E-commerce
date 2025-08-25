@extends('sellers.partials.app')
@section('title', __('messages.complaint_details_title'))
@section('content')

<div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow mt-6">

    <div class="mb-6 border-b pb-4">
        <h2 class="text-xl font-bold text-gray-800 mb-2">{{ $ticket->subject }}</h2>
        <p class="text-sm text-gray-600 mb-3">{{ $ticket->message }}</p>
        <p class="text-xs text-gray-500">{{ __('messages.on_date') }} {{ $ticket->created_at->format('Y-m-d H:i') }}</p>

        @if($ticket->images && count($ticket->images))
            <div class="mt-3 flex flex-wrap gap-3">
                @foreach($ticket->images as $image)
                    <img src="{{ Storage::url($image->path) }}" class="w-20 h-20 object-cover rounded-md border">
                @endforeach
            </div>
        @endif
    </div>

    @isset($ticket?->replies)
        <div id="replies-container" class="space-y-4 max-h-[600px] overflow-y-auto mb-6 px-2 sm:px-6">
            @foreach($ticket->replies as $reply)
                @php
                    $isSeller = $reply->sender_type === 'seller';
                    $bubbleColor = $isSeller ? 'bg-blue-100 text-right' : 'bg-gray-100 text-left';
                    $alignment = $isSeller ? 'justify-end pr-4' : 'justify-start pl-4';
                    $senderLabel = $isSeller ? __('messages.seller_label') : __('messages.admin_label');
                    $tagColor = $isSeller ? 'bg-blue-200 text-blue-800' : 'bg-gray-300 text-gray-800';
                @endphp

                <div class="flex {{ $alignment }}">
                    <div class="w-full max-w-2xl">
                        <div class="mb-1 {{ $isSeller ? 'text-right pr-4' : 'text-left pl-4' }}">
                            <span class="inline-block text-[12px] px-3 py-0.5 rounded-full {{ $tagColor }} font-semibold shadow">
                                {{ $senderLabel }}
                            </span>
                        </div>

                        <div class="{{ $bubbleColor }} p-4 rounded-lg shadow relative">
                            <p class="text-sm text-gray-800 mb-2 leading-relaxed">{{ $reply->message }}</p>

                            @if($reply->images)
                                <img src="{{ Storage::url($reply?->images?->first()?->path) }}" class="w-40 h-40 object-cover rounded mt-2 border">
                            @endif

                            <p class="text-[10px] text-gray-500 mt-2">{{ $reply->created_at->format('H:i - Y/m/d') }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endisset

    <form action="{{ route('support.complaint.insert_reply', $ticket->id) }}" method="POST" enctype="multipart/form-data" class="border-t pt-4">
        @csrf

        <div class="flex flex-col sm:flex-row gap-4 items-center">
            <input type="text" name="message" placeholder="{{ __('messages.write_your_reply') }}..." required
                   class="flex-1 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">

            <input type="file" name="images[]" accept="image/*"
                   class="text-sm text-gray-600 border border-gray-300 rounded-md cursor-pointer">

            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold px-4 py-2 rounded">
                {{ __('messages.send_button') }}
            </button>
        </div>
    </form>
</div>
@endsection