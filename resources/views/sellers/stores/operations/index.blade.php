@extends('sellers.partials.app')
@section('title', __('messages.manage_stores_title'))
@section('content')

<div class="bg-white shadow-lg rounded-lg p-4 sm:p-6 mx-auto w-full max-w-6xl">
    <h1 class="text-2xl font-bold mb-4 text-center text-gray-800">{{ __('messages.manage_stores_heading') }}</h1>

    <div class="overflow-x-auto w-full">
        <div class="w-full max-w-5xl mx-auto"> 
            <table class="w-full min-w-max border-collapse bg-white shadow-md rounded-lg">
                <thead class="bg-indigo-600 text-white text-sm sm:text-base">
                    <tr>
                        <th class="p-2 sm:p-3 text-center whitespace-nowrap">{{ __('messages.address') }}</th>
                        <th class="p-2 sm:p-3 text-center whitespace-nowrap">{{ __('messages.store_name') }}</th>
                        <th class="p-2 sm:p-3 text-center whitespace-nowrap">{{ __('messages.description') }}</th>
                        <th class="p-2 sm:p-3 text-center whitespace-nowrap">{{ __('messages.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stores as $store)
                    <tr class="border-b hover:bg-gray-100 text-sm sm:text-base">
                        <td class="p-2 sm:p-3 text-center break-words max-w-[180px]">
                            @if ($store->city?->name && $store->area?->name && $store->street)
                                {{ $store->city->name . ' ' . $store->area->name . ' ' . __('messages.street') . ' ' . $store->street }}
                            @endif
                        </td>
                        <td class="p-2 sm:p-3 text-center break-words max-w-[150px]">{{ $store->name }}</td>
                        <td class="p-2 sm:p-3 text-center break-words max-w-[180px]">{{ $store->description }}</td>
                        <td class="p-2 sm:p-3 flex justify-center flex-wrap gap-2">
                            <a href="{{ route('seller.store.edit', $store->id) }}" class="bg-green-500 hover:bg-green-600 text-white py-1 px-2 rounded text-xs sm:text-sm">{{ __('messages.edit') }}</a>
                            <button onclick="confirmDelete('{{ route('seller.store.delete', $store->id) }}')" class="bg-red-500 hover:bg-red-600 text-white py-1 px-2 rounded text-xs sm:text-sm">{{ __('messages.delete') }}</button>
                            <a href="{{ route('seller.store.staticses.details', $store->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-2 rounded text-xs sm:text-sm">{{ __('messages.enter') }}</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDelete(deleteUrl) {
        Swal.fire({
            title: '{{ __('messages.confirm_delete_title') }}',
            text: '{{ __('messages.confirm_delete_text') }}',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: '{{ __('messages.confirm_delete_button') }}',
            cancelButtonText: '{{ __('messages.cancel') }}'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = deleteUrl;
            }
        });
    }
</script>
@endsection