@extends('sellers.partials.app')
@section('title', __('messages.new_complaint_title'))
@section('content')

<div class="max-w-4xl mx-auto bg-white p-8 mt-10 rounded-2xl shadow-md">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">✉️ {{ __('messages.new_complaint_title') }}</h1>

    <form action="{{ route('support.complaint.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div>
            <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.complaint_subject') }}</label>
            <input type="text" name="subject" id="subject" value="{{ old('subject') }}"
                class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('subject') border-red-500 @enderror">
            @error('subject')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="details" class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.complaint_details') }}</label>
            <textarea name="details" id="details" rows="5"
                class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('details') border-red-500 @enderror">{{ old('details') }}</textarea>
            @error('details')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="images" class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.images_optional') }}</label>
            <input type="file" name="images[]" id="images" multiple
                class="w-full text-sm text-gray-600 border border-gray-300 rounded-md cursor-pointer @error('images') border-red-500 @enderror">
            @if ($errors->has('images.*'))
                <ul class="text-red-600 text-sm mt-2 space-y-1">
                    @foreach ($errors->get('images.*') as $messages)
                        @foreach ($messages as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    @endforeach
                </ul>
            @endif
        </div>

        {{-- Submit --}}
        <div>
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-xl shadow transition">
                {{ __('messages.send_complaint') }}
            </button>
        </div>
    </form>

    @isset($tickets)
        @if ($tickets->count())
            <div class="mt-10">
                <h2 class="text-xl font-semibold text-gray-800 border-b pb-2 mb-4">📄 {{ __('messages.previous_complaints') }}</h2>

                <div class="space-y-3">
                    @foreach ($tickets as $ticket)
                        <div class="flex items-center justify-between bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 shadow-sm hover:shadow-md transition">
                            <div class="text-sm text-gray-800 font-medium truncate">
                                {{ $ticket->subject }}
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('support.complaint.show', $ticket->id) }}"
                                    class="bg-blue-500 text-white text-xs px-3 py-1 rounded hover:bg-blue-600 transition">{{ __('messages.view') }}</a>

                                <form action="{{ route('support.complaint.delete', $ticket->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 text-white text-xs px-3 py-1 rounded hover:bg-red-600 transition">
                                        {{ __('messages.close') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    @endisset
</div>

@endsection