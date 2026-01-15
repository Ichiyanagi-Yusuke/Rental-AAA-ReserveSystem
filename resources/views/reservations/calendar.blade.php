{{-- resources/views/reservations/calendar.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            予約カレンダー
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            {{-- カレンダーコントロール --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-4">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    {{-- 前月・次月ボタン --}}
                    <div class="flex items-center gap-2">
                        <a href="{{ route('reservations.calendar', ['year' => $prevMonth->year, 'month' => $prevMonth->month]) }}"
                           class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-semibold rounded-md text-gray-700 hover:bg-gray-50">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            前月
                        </a>

                        <div class="text-lg font-semibold text-gray-800 px-4">
                            {{ $baseDate->format('Y年n月') }}
                        </div>

                        <a href="{{ route('reservations.calendar', ['year' => $nextMonth->year, 'month' => $nextMonth->month]) }}"
                           class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-semibold rounded-md text-gray-700 hover:bg-gray-50">
                            次月
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>

                    {{-- 年月選択プルダウン --}}
                    <div class="flex items-center gap-2">
                        <form method="GET" action="{{ route('reservations.calendar') }}" class="flex items-center gap-2">
                            <select name="year"
                                    class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                @foreach ($yearOptions as $y)
                                    <option value="{{ $y }}" {{ $y == $currentYear ? 'selected' : '' }}>
                                        {{ $y }}年
                                    </option>
                                @endforeach
                            </select>

                            <select name="month"
                                    class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                @foreach ($monthOptions as $m)
                                    <option value="{{ $m }}" {{ $m == $currentMonth ? 'selected' : '' }}>
                                        {{ $m }}月
                                    </option>
                                @endforeach
                            </select>

                            <button type="submit"
                                    class="inline-flex items-center px-3 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-md hover:bg-indigo-700">
                                表示
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- カレンダー表示 --}}
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-2 py-2 text-xs font-semibold text-red-600 w-1/7">日</th>
                                <th class="border border-gray-300 px-2 py-2 text-xs font-semibold text-gray-700 w-1/7">月</th>
                                <th class="border border-gray-300 px-2 py-2 text-xs font-semibold text-gray-700 w-1/7">火</th>
                                <th class="border border-gray-300 px-2 py-2 text-xs font-semibold text-gray-700 w-1/7">水</th>
                                <th class="border border-gray-300 px-2 py-2 text-xs font-semibold text-gray-700 w-1/7">木</th>
                                <th class="border border-gray-300 px-2 py-2 text-xs font-semibold text-gray-700 w-1/7">金</th>
                                <th class="border border-gray-300 px-2 py-2 text-xs font-semibold text-blue-600 w-1/7">土</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($calendar as $week)
                                <tr>
                                    @foreach ($week as $index => $day)
                                        @php
                                            $isSunday = $index === 0;
                                            $isSaturday = $index === 6;
                                            $hasReservations = $day['reservation_count'] > 0;
                                        @endphp
                                        <td class="border border-gray-300 align-top h-24 {{ !$day['isCurrentMonth'] ? 'bg-gray-50' : '' }} {{ $day['isToday'] ? 'bg-yellow-50' : '' }}">
                                            @if ($day['isCurrentMonth'])
                                                <a href="{{ route('reservations.index', ['date' => $day['dateStr']]) }}"
                                                   class="block p-2 hover:bg-indigo-50 h-full transition">
                                                    <div class="text-sm font-semibold mb-1 {{ $isSunday ? 'text-red-600' : ($isSaturday ? 'text-blue-600' : 'text-gray-900') }}">
                                                        {{ $day['date']->day }}
                                                        @if ($day['isToday'])
                                                            <span class="ml-1 text-xs bg-yellow-400 text-gray-900 px-1 rounded">今日</span>
                                                        @endif
                                                    </div>

                                                    @if ($hasReservations)
                                                        <div class="space-y-1">
                                                            <div class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">
                                                                予約: {{ $day['reservation_count'] }}件
                                                            </div>
                                                            <div class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">
                                                                利用者: {{ $day['guest_count'] }}人
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="text-xs text-gray-400">
                                                            予約なし
                                                        </div>
                                                    @endif
                                                </a>
                                            @else
                                                <div class="p-2">
                                                    <div class="text-sm font-semibold text-gray-400">
                                                        {{ $day['date']->day }}
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- 凡例 --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-4">
                <h3 class="text-sm font-semibold text-gray-800 mb-2">凡例</h3>
                <div class="flex flex-wrap gap-4 text-xs text-gray-600">
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 bg-yellow-50 border border-gray-300"></div>
                        <span>今日</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 bg-blue-100 border border-gray-300"></div>
                        <span>予約件数</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 bg-green-100 border border-gray-300"></div>
                        <span>利用者数</span>
                    </div>
                    <div class="text-gray-500">
                        ※ 日付をクリックするとその日の予約一覧が表示されます
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
