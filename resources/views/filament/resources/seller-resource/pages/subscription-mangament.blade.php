<x-filament::page>
    <h2 class="text-2xl font-bold mb-6 text-gray-800">📦 اشتراكات البائعين</h2>

    <div class="overflow-x-auto rounded-xl shadow">
        <table class="w-full text-sm text-left border border-gray-200">
            <thead class="bg-gray-50 text-gray-700">
                <tr>
                    <th class="px-4 py-3">seller</th>
                    <th class="px-4 py-3">boundle</th>
                    <th class="px-4 py-3">status</th>
                    <th class="px-4 py-3">Creation Date</th>
                    <th class="px-4 py-3">Expired Date </th>
                    <th class="px-4 py-3 text-center"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @foreach ($record->subscriptions as $sub)
                    <tr class=" text-gray-600 hover:bg-gray-50 transition duration-150">
                        <td class="px-4 py-2 font-medium text-gray-800">
                            {{ $record->name }}
                        </td>
                        <td class="px-4 py-2 text-gray-700">
                            {{ $sub->stripe_status }}
                        </td>
                        <td class="px-4 py-2">
                            <span class=" text-gray-600 text-xs font-semibold px-2 py-1 rounded-full 
                                {{ $sub->stripe_status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $sub->ends_at === null ? 'Active' : 'Not Active' }}
                            </span>
                        </td>
                        <td class="px-4 py-2 text-gray-600">
                            {{ $sub->created_at->format('Y-m-d') }}
                        </td>
                        <td class=" text-gray-600 px-4 py-2 text-gray-600">
                            {{  $sub?->stripe_status == 'trialing' ? $sub?->created_at->addDays(90)->format('Y:m:d') :$sub?->created_at->addDays(365)?->format('Y:m:d') }}
                        </td>
                        <td class="px-4 py-2 text-center">
                        @if ( is_null($sub->ends_at))
                        <x-filament::button
    color="danger"
    size="sm"
    wire:click="cancelSubscription('{{ $sub->id }}')"
    wire:confirm="هل انت متاكد من الغاء اشتراك البائع ؟"

>
    ❌ إلغاء
</x-filament::button>

@endif



                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
    </div>


</x-filament::page>
