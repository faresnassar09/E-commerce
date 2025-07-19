<div class="bg-gray-100 min-h-screen">

    @vite('resources/css/app.css')

    <style>
        .arrow-box {
            position: relative;
            padding-left: 12px;
        }

        .arrow-box::before {
            content: '';
            position: absolute;
            top: 50%;
            left: -8px;
            transform: translateY(-50%) rotate(45deg);
            width: 8px;
            height: 8px;
            background-color: currentColor;
            clip-path: polygon(0 50%, 100% 0, 100% 100%);
        }

        @keyframes countdown {
            from { width: 100%; }
            to { width: 0%; }
        }

        .animate-countdown {
            animation: countdown 5s linear forwards;
        }
    </style>

    <div class="max-w-7xl mx-auto px-4 py-6 mt-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- ملخص الطلب -->


            <!-- المنتجات -->
            <div class="lg:col-span-2 space-y-4">
                <h1 class="text-xl font-bold text-gray-800 mb-2">
                    🛒 {{ __('messages.cart_items') }}
                    <span class="text-sm text-gray-500">({{ count($cartItems) }} {{ __('messages.product') }})</span>
                </h1>

                @foreach ($cartItems as $item)
                    <div class="bg-white rounded-lg shadow-sm flex flex-col sm:flex-row gap-3 p-3 relative">
                        <!-- صورة المنتج -->
                        <div class="w-full sm:w-24 h-24 overflow-hidden rounded">
                            <img src="{{ Storage::url($item->product->images->first()->path) }}" alt="product" class="w-full h-full object-contain">
                        </div>

                        <!-- تفاصيل -->
                        <div class="flex-grow space-y-1">
                            <h2 class="text-sm font-semibold text-gray-800">{{ $item->product->name }}</h2>
                            <p class="text-sm text-gray-600">{{ Str::words($item->product->description, 3) }}</p>

                            <div class="text-xs text-gray-700 mt-1 flex flex-wrap gap-2 items-center">
                                <span>{{ __('messages.much') }}:
                                    <select wire:model="quantities.{{ $item->id }}" class="border rounded px-1 py-0.5 text-xs">
                                        <option value="" hidden>{{ __('messages.choose') }}</option>
                                        @for ($i = 1; $i <= $item->product->available_quantity; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </span>

                                <span class="text-gray-500">:{{ __('messages.available') }} {{ $item->product->available_quantity }}</span>
                            </div>

                            <div>
                                @if ($item->product->discount > 0)
                                    <p class="text-red-600 font-bold text-sm">
                                        {{ $item->product->price - $item->product->discount }} EG
                                        <br>
                                        <span class="text-gray-400 line-through ml-1 text-xs">{{ $item->product->price }} EG</span>
                                    </p>
                                @else
                                    <p class="text-green-600 font-bold text-sm">{{ $item->product->price }} EG</p>
                                @endif
                            </div>
                        </div>

                        <!-- أدوات التحكم -->
                        <div class="flex flex-row sm:flex-col items-end gap-2 sm:ml-2 mt-2 sm:mt-0">
                            <button wire:click="deleteItem({{ $item->id }})" class="text-red-500 text-xs">🗑 {{ __('messages.delete') }}</button>

                            <label class="flex items-center gap-1 text-orange-600 text-xs cursor-pointer">
                                <input type="checkbox" value="{{ $item->id }}" wire:model.live="selectedItems" class="accent-orange-500 w-4 h-4">
                                <span>{{ __('messages.select') }}</span>
                            </label>
                        </div>
                    </div>
                @endforeach
                            <div class="bg-white p-4 rounded-lg shadow space-y-4">
                <h2 class="text-lg font-bold border-b pb-2 text-gray-800">{{ __('messages.order_summary') }}</h2>

                <!-- طريقة الدفع -->
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">{{ __('messages.payment_method') }}</label>
                    <select wire:model.live="paymentMethod" required class="w-full border px-2 py-1 rounded text-sm">
                        <option value="">{{ __('messages.payment_method') }}</option>
                        <option value="cash">{{ __('messages.cash') }}</option>
                        <option value="visa">{{ __('messages.visa') }}</option>
                    </select>
                </div>

                <!-- رقم احتياطي -->
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">{{ __('messages.backup_number') }}</label>
                    <input type="number" wire:model.live="backupPhoneNumber" class="w-full border px-2 py-1 rounded text-sm">
                </div>

                <!-- التعليقات -->
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">{{ __('messages.comments') }}</label>
                    <textarea wire:model.live="Comment" placeholder="{{ __('messages.comments_details') }} ..." class="w-full border px-2 py-1 rounded text-sm"></textarea>
                </div>

                <!-- العناوين -->
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">اختر عنوان</label>
                    <select wire:click="getUserAddresses($event.target.value)" class="w-full border px-2 py-1 rounded text-sm">
                        <option value="">اختر عنوان</option>
                        @if($userAddresses)
                            @foreach($userAddresses as $address)
                                <option value="{{ $address->id }}">
                                    {{ $address?->city->name }}/{{ $address?->area->name }}/{{ $address?->street }}
                                </option>
                            @endforeach
                        @else
                            <option value="">ليس لديك عناوين. اضغط لإضافة عنوان.</option>
                        @endif
                    </select>
                    <a href="{{ route('user.create_address') }}" class="text-blue-500 text-sm underline mt-1 inline-block">➕ إضافة عنوان</a>
                </div>

                <!-- الإجمالي -->
                <div class="text-sm text-gray-700">
                    <hr class="my-2">
                    <div class="flex justify-between font-bold text-base">
                        <span>{{ __('messages.total') }}</span>
                        <span>{{ $total }} EG</span>
                    </div>
                </div>

                <!-- زر التأكيد -->
                <button wire:click="placeOrder()" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded text-sm transition">
                    {{ __('messages.confirm') }}
                </button>

                <!-- رسالة خطأ -->
                @if (session()->has('faildMessage'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative text-sm mt-2" role="alert">
                        <strong class="font-bold">خطأ!</strong>
                        <span class="block">{{ session('faildMessage') }}</span>
                    </div>
                @endif
            </div>
            </div>
        </div>
    </div>
</div>
