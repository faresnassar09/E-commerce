<div class="flex gap-2">

<button wire:click="trackOrder($id)" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-green-700">{{__('messages.traking') }}</button>
          <button wire:click="cancel({{ $this->id }})" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-yellow-600">{{ __('messages.cancel') }}</button>
          <button onclick="openSellerContact()" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 flex items-center gap-1">
  <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-black" fill="currentColor" viewBox="0 0 24 24">
    <path d="M6.62 10.79a15.05 15.05 0 006.59 6.59l2.2-2.2a1 1 0 011.11-.21 11.72 11.72 0 003.64.58 1 1 0 011 1V20a1 1 0 01-1 1A17 17 0 013 4a1 1 0 011-1h3.5a1 1 0 011 1 11.72 11.72 0 00.58 3.64 1 1 0 01-.21 1.11l-2.2 2.2z" />
  </svg>
  <span> {{__('messages.call_seller')}}</span>
</button>
{{ $this->id }}

</div>
