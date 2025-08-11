


<div> 
        @vite(['resources/css/app.css', 'resources/js/app.js'])



        <div class="max-w-7xl mx-auto p-4">
   
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">الاسم</label>
                    <input type="text" class="w-full rounded border-gray-300" wire:model="name">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">ساعات الشيفت</label>
                    <input type="number" class="w-full rounded border-gray-300" wire:model="shiftHours">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">الراتب الشهري</label>
                    <input type="number" class="w-full rounded border-gray-300" wire:model="monthlySalary">
                </div>
            </div>

            <div class="overflow-auto">
                <table class="min-w-full bg-white border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                        <div class="flex justify-end mb-4">
    <button onclick="printTable()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
        🖨️ Print
    </button>
</div>
                    <div class="mb-4">
    <label class="block mb-1 text-sm font-medium text-gray-700">اختار أول يوم في الشهر</label>
    <input type="date" class="rounded border-gray-300" wire:model="startDate">
</div>

                    <div class="mb-4">
    <label class="block mb-1 text-sm font-medium text-gray-700">حساب التاخير </label>
    <input type="number" class="rounded border-gray-300" wire:model.lazy="delayCalc">
</div>
                            <th class="border px-2 py-1 text-xs">يوم</th>
                            <th class="border px-2 py-1 text-xs">التاريخ</th>
                            <th class="border px-2 py-1 text-xs">اسم اليوم</th>

                            <th class="border px-2 py-1 text-xs">الدخول</th>
                            <th class="border px-2 py-1 text-xs">الخروج</th>
                            <th class="border px-2 py-1 text-xs">اجمالي ساعات العمل</th>
                            <th class="border px-2 py-1 text-xs">التاخير</th>
                            <th class="border px-2 py-1 text-xs">الاضافي</th>
                            <th class="border px-2 py-1 text-xs">مبلغ التاخير</th>
                            <th class="border px-2 py-1 text-xs">مبلغ الاضافي</th>
                            <th class="border px-2 py-1 text-xs">صافي اليوم</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($days as $i => $day)
                            <tr class="text-xs">
                                <td class="border px-2 py-1 text-center">{{ $i + 1 }}</td>
                                <td class="border px-2 py-1">
                                    <input type="date" wire:model.lazy="days.{{ $i }}.date" class="w-full rounded border-gray-200">
                                </td>
                                <td class="border px-2 py-1 text-center">
    @if (!empty($day['date']))
        {{ \Carbon\Carbon::parse($day['date'])->translatedFormat('l') }}
    @else
        -
    @endif
</td>
                                <td class="border px-2 py-1">
                                    <input type="time" wire:model.lazy="days.{{ $i }}.in" class="w-full rounded border-gray-200">
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="time" wire:model.lazy="days.{{ $i }}.out" class="w-full rounded border-gray-200">
                                </td>
                                <td class="border px-2 py-1 text-center">{{ $day['worked_hours'] }}</td>
                                <td class="border px-2 py-1 text-center">{{ $day['late_hours'] }}</td>
                                <td class="border px-2 py-1 text-center">{{ $day['extra_hours'] }}</td>
                                <td class="border px-2 py-1 text-center">{{ number_format($day['late_amount'], 2) }}</td>
                                <td class="border px-2 py-1 text-center">{{ number_format($day['extra_amount'], 2) }}</td>
                                <td class="border px-2 py-1 text-center font-semibold">{{ number_format($day['day_amount'], 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6 bg-gray-50 p-4 rounded shadow text-sm">
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <div><strong>عدد الايام:</strong> {{ $summary['days_counted'] }}</div>
                    <div><strong>اجمالي ساعات التاخير:</strong> {{ $summary['total_late_hours'] }}</div>
                    <div><strong>اجمالي ساعات الاضافي:</strong> {{ $summary['total_extra_hours'] }}</div>
                    <div><strong>اجمالي خصم التاخير:</strong> {{ number_format($summary['total_late_amount'], 2) }}</div>
                    <div><strong>اجمالي الاضافي:</strong> {{ number_format($summary['total_extra_amount'], 2) }}</div>
                    <div><strong>اجمالي المستحق:</strong> {{ number_format($summary['total_amount'], 2) }}</div>
                </div>
            </div>
        </div>

<script>
    function printTable() {
        const allRows = document.querySelectorAll('tbody tr');
        allRows.forEach(row => {
            const dateInput = row.querySelector('input[type="date"]');

        });

        window.print();

        allRows.forEach(row => {
            row.style.display = '';
        });
    }
</script>

    </div>
