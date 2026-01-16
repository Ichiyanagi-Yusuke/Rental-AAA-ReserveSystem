{{-- resources/views/reservations/search.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            予約検索
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- フラッシュメッセージ --}}
            @if (session('status'))
                <div class="p-3 rounded-md bg-blue-50 border border-blue-200 text-sm text-blue-800">
                    {{ session('status') }}
                </div>
            @endif

            {{-- 検索フォーム --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">検索条件</h3>

                <form method="POST" action="{{ route('reservations.search.results') }}">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        {{-- 電話番号 --}}
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                                電話番号
                            </label>
                            <input type="text" id="phone" name="phone"
                                value="{{ old('phone', $searchParams['phone'] ?? '') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="例: 090-1234-5678">
                        </div>

                        {{-- メールアドレス --}}
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                メールアドレス
                            </label>
                            <input type="email" id="email" name="email"
                                value="{{ old('email', $searchParams['email'] ?? '') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="例: example@example.com">
                        </div>

                        {{-- 代表者姓 --}}
                        <div>
                            <label for="rep_last_name" class="block text-sm font-medium text-gray-700 mb-1">
                                代表者姓
                            </label>
                            <input type="text" id="rep_last_name" name="rep_last_name"
                                value="{{ old('rep_last_name', $searchParams['rep_last_name'] ?? '') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="例: 山田">
                        </div>

                        {{-- 代表者名 --}}
                        <div>
                            <label for="rep_first_name" class="block text-sm font-medium text-gray-700 mb-1">
                                代表者名
                            </label>
                            <input type="text" id="rep_first_name" name="rep_first_name"
                                value="{{ old('rep_first_name', $searchParams['rep_first_name'] ?? '') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="例: 太郎">
                        </div>

                        {{-- 代表者姓（フリガナ） --}}
                        <div>
                            <label for="rep_last_name_kana" class="block text-sm font-medium text-gray-700 mb-1">
                                代表者姓（フリガナ）
                            </label>
                            <input type="text" id="rep_last_name_kana" name="rep_last_name_kana"
                                value="{{ old('rep_last_name_kana', $searchParams['rep_last_name_kana'] ?? '') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="例: ヤマダ">
                        </div>

                        {{-- 代表者名（フリガナ） --}}
                        <div>
                            <label for="rep_first_name_kana" class="block text-sm font-medium text-gray-700 mb-1">
                                代表者名（フリガナ）
                            </label>
                            <input type="text" id="rep_first_name_kana" name="rep_first_name_kana"
                                value="{{ old('rep_first_name_kana', $searchParams['rep_first_name_kana'] ?? '') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="例: タロウ">
                        </div>

                        {{-- 来店日 --}}
                        <div>
                            <label for="visit_date" class="block text-sm font-medium text-gray-700 mb-1">
                                来店日
                            </label>
                            <input type="date" id="visit_date" name="visit_date"
                                value="{{ old('visit_date', $searchParams['visit_date'] ?? '') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-md hover:bg-indigo-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            検索
                        </button>

                        <a href="{{ route('reservations.search') }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-semibold rounded-md text-gray-700 hover:bg-gray-50">
                            クリア
                        </a>
                    </div>
                </form>
            </div>

            {{-- 検索結果 --}}
            @if (isset($reservations))
                <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
                    <div class="p-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">
                            検索結果（{{ $reservations->total() }} 件）
                        </h3>
                    </div>

                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="bg-gray-100 text-left text-xs font-semibold text-gray-600">
                                <th class="px-4 py-2 whitespace-nowrap">代表者名</th>
                                <th class="px-4 py-2 whitespace-nowrap">電話番号</th>
                                <th class="px-4 py-2 whitespace-nowrap">メールアドレス</th>
                                <th class="px-4 py-2 whitespace-nowrap">来店日</th>
                                <th class="px-4 py-2 whitespace-nowrap">予約日時</th>
                                <th class="px-4 py-2 whitespace-nowrap text-right">人数</th>
                                <th class="px-4 py-2 whitespace-nowrap">経路</th>
                                {{-- <th class="px-4 py-2 whitespace-nowrap">ゲレンデ</th> --}}
                                <th class="px-4 py-2 whitespace-nowrap text-right">操作</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($reservations as $reservation)
                                {{-- @php
                                    $repName = trim(
                                        ($reservation->rep_last_name ?? '') .
                                            ' ' .
                                            ($reservation->rep_first_name ?? ''),
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
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">
                                        {{ $reservation->phone }}
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">
                                        {{ $reservation->email }}
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        {{ $reservation->visit_date }}
                                        @if ($reservation->visit_time)
                                            <span class="text-xs text-gray-500">
                                                {{ $reservation->visit_time }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        {{ $reservation->created_at }}
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap text-right">
                                        {{ $reservation->number_of_people ?? 0 }} 人
                                    </td>
                                    {{-- <td class="px-4 py-2 whitespace-nowrap">
                                        {{ optional($reservation->resort)->name ?? '未設定' }}
                                    </td> --}}
                                    {{-- 追加: 予約経路 --}}
                                    <td class="px-4 py-2 whitespace-nowrap text-right">
                                        @if ($reservation->source === 'external')
                                            <span
                                                class="inline-block
                                        px-2 py-1 text-xs font-bold leading-none text-white bg-purple-500 rounded">
                                                Eレンタル
                                            </span>
                                        @else
                                            <span
                                                class="inline-block px-2 py-1 text-xs font-bold leading-none text-white bg-blue-500 rounded">
                                                HP Web
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap text-right">
                                        {{-- <a href="{{ route('reservations.show', $reservation->id) }}"
                                            class="inline-flex items-center px-3 py-1.5 rounded-md border border-indigo-300 text-xs text-indigo-700 bg-indigo-50 hover:bg-indigo-100">
                                            詳細
                                        </a> --}}

                                        @if ($reservation->isExternal())
                                            {{-- route('e_rental_reservations.show') を使用 --}}
                                            <a href="{{ route('e_rental_reservations.show', $reservation->original_id) }}"
                                                class="inline-flex items-center px-3 py-1.5 rounded-md border border-indigo-300 text-xs text-indigo-700 bg-indigo-50 hover:bg-indigo-100">
                                                詳細
                                            </a>
                                        @else
                                            {{-- 既存の予約詳細へ --}}
                                            <a href="{{ route('reservations.show', $reservation->original_id) }}"
                                                class="inline-flex items-center px-3 py-1.5 rounded-md border border-indigo-300 text-xs text-indigo-700 bg-indigo-50 hover:bg-indigo-100">
                                                詳細
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-6 text-center text-gray-500">
                                        検索条件に一致する予約が見つかりませんでした。
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div>
                    {{ $reservations->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
