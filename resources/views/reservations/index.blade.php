{{-- resources/views/reservations/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if (!empty($filterLabel))
                {{ $filterLabel }}
                @if (!empty($targetDate))
                    <span class="text-sm text-gray-500 ml-2">
                        （{{ $targetDate }}）
                    </span>
                @endif
            @else
                予約一覧
            @endif
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-4">

            {{-- フラッシュメッセージ --}}
            @if (session('status'))
                <div class="p-3 rounded-md bg-blue-50 border border-blue-200 text-sm text-blue-800">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="bg-gray-100 text-left text-xs font-semibold text-gray-600">
                            <th class="px-4 py-2 whitespace-nowrap">代表者名</th>
                            <th class="px-4 py-2 whitespace-nowrap">来店日</th>
                            <th class="px-4 py-2 whitespace-nowrap">予約日時</th>
                            <th class="px-4 py-2 whitespace-nowrap text-right">人数</th>
                            <th class="px-4 py-2">予約経路</th>
                            {{-- <th class="px-4 py-2 whitespace-nowrap">ゲレンデ</th> --}}
                            <th class="px-4 py-2 whitespace-nowrap text-right">操作</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($reservations as $reservation)
                            {{-- @php
                                $repName = trim(
                                    ($reservation->rep_last_name ?? '') . ' ' . ($reservation->rep_first_name ?? ''),
                                );
                                $visitDate = $reservation->visit_date
                                    ? \Carbon\Carbon::parse($reservation->visit_date)->format('Y-m-d')
                                    : '';
                                $createdAt = $reservation->created_at
                                    ? $reservation->created_at->format('Y-m-d H:i')
                                    : '';
                            @endphp --}}
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 whitespace-nowrap">

                                    {{-- <a href="{{ route('reservations.show', $reservation->original_id) }}"
                                        class="text-indigo-600 hover:underline">
                                        {{ $reservation->rep_name ?: '（氏名未登録）' }}
                                    </a> --}}


                                    @if ($reservation->isExternal())
                                        {{-- route('e_rental_reservations.show') を使用 --}}
                                        <a href="{{ route('e_rental_reservations.show', $reservation->original_id) }}"
                                            class="text-indigo-600 hover:text-indigo-900">
                                            {{ $reservation->rep_name ?: '（氏名未登録）' }}
                                        </a>
                                    @else
                                        {{-- 既存の予約詳細へ --}}
                                        <a href="{{ route('reservations.show', $reservation->original_id) }}"
                                            class="text-indigo-600 hover:text-indigo-900">
                                            {{ $reservation->rep_name ?: '（氏名未登録）' }}
                                        </a>
                                    @endif




                                </td>
                                <td class="px-4 py-2 whitespace-nowrap">
                                    {{ $reservation->visit_date }}
                                    {{-- {{ $visitDate }} --}}
                                    @if ($reservation->visit_time)
                                        <span class="text-xs text-gray-500">
                                            {{ $reservation->visit_time }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap">
                                    {{ $reservation->created_at }}
                                    {{-- {{ $createdAt }} --}}
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-right">
                                    {{ $reservation->number_of_people ?? 0 }} 人
                                </td>
                                {{-- <td class="px-4 py-2 whitespace-nowrap">
                                    {{ optional($reservation->resort)->name ?? '未設定' }}
                                </td> --}}

                                <td class="px-4 py-2 text-sm">
                                    @if ($reservation->source === 'external')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            Eレンタル
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            HP Web
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-right">


                                    {{-- <a href="{{ route('reservations.show', $reservation->id) }}"
                                        class="inline-flex items-center px-3 py-1.5 rounded-md border border-indigo-300 text-xs text-indigo-700 bg-indigo-50 hover:bg-indigo-100">
                                        詳細
                                    </a> --}}


                                    {{-- 修正後 --}}
                                    @if ($reservation->isExternal())
                                        {{-- route('e_rental_reservations.show') を使用 --}}
                                        <a href="{{ route('e_rental_reservations.show', $reservation->original_id) }}"
                                            class="text-indigo-600 hover:text-indigo-900">
                                            詳細
                                        </a>
                                    @else
                                        {{-- 既存の予約詳細へ --}}
                                        <a href="{{ route('reservations.show', $reservation->original_id) }}"
                                            class="text-indigo-600 hover:text-indigo-900">
                                            詳細
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                    予約が登録されていません。
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div>
                {{ $reservations->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
