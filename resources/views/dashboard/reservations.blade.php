<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            予約メニュー
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                {{-- 予約管理 --}}
                <div class="bg-white shadow-sm sm:rounded-lg p-6 flex flex-col justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">
                            予約管理
                        </h3>
                        <p class="text-sm text-gray-600">
                            社内用の予約登録・一覧を行います。
                        </p>
                    </div>
                    <div class="mt-4 flex flex-wrap gap-3">
                        <a href="{{ route('reservations.create.header') }}"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-md hover:bg-indigo-700">
                            新規予約登録
                        </a>
                        <a href="{{ route('reservations.index') }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-semibold rounded-md text-gray-700 hover:bg-gray-50">
                            予約一覧
                        </a>
                    </div>
                </div>

                {{-- 予約検索カード --}}
                <a href="{{ route('reservations.search') }}"
                    class="flex flex-col justify-between bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-5 hover:shadow-md hover:border-purple-200 transition">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900">
                                予約検索
                            </h3>
                            <p class="mt-1 text-xs text-gray-500">
                                電話番号、メールアドレス、代表者名、来店日などで予約を検索します。
                            </p>
                        </div>
                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-purple-50">
                            <svg class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center justify-between text-xs">
                        <span class="inline-flex items-center rounded-full px-2.5 py-1 bg-gray-100 text-gray-600">
                            検索フォーム
                        </span>
                        <span class="inline-flex items-center text-purple-600 font-medium">
                            開く
                            <svg class="ml-1 h-3 w-3" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </span>
                    </div>
                </a>

                {{-- 予約カレンダーカード --}}
                <a href="{{ route('reservations.calendar') }}"
                    class="flex flex-col justify-between bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-5 hover:shadow-md hover:border-teal-200 transition">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900">
                                予約カレンダー
                            </h3>
                            <p class="mt-1 text-xs text-gray-500">
                                カレンダー形式で予約状況を確認できます。日別の予約件数と利用者数を表示します。
                            </p>
                        </div>
                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-teal-50">
                            <svg class="h-5 w-5 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center justify-between text-xs">
                        <span class="inline-flex items-center rounded-full px-2.5 py-1 bg-gray-100 text-gray-600">
                            カレンダー表示
                        </span>
                        <span class="inline-flex items-center text-teal-600 font-medium">
                            開く
                            <svg class="ml-1 h-3 w-3" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </span>
                    </div>
                </a>

                {{-- 本日の予約 --}}
                <a href="{{ route('reservations.index', ['filter' => 'today']) }}"
                    class="block bg-white shadow-sm rounded-lg p-5 hover:bg-gray-50 transition">
                    <h3 class="text-lg font-semibold text-gray-800 mb-1">
                        本日の予約
                    </h3>
                    <p class="text-sm text-gray-500 mb-3">
                        本日来店予定の予約を一覧表示します。
                    </p>
                    <div class="text-xs text-gray-400">
                        代表者名 / 来店日 / 予約日時 / 人数 を確認できます。
                    </div>
                </a>

                {{-- 明日の予約 --}}
                <a href="{{ route('reservations.index', ['filter' => 'tomorrow']) }}"
                    class="block bg-white shadow-sm rounded-lg p-5 hover:bg-gray-50 transition">
                    <h3 class="text-lg font-semibold text-gray-800 mb-1">
                        明日の予約
                    </h3>
                    <p class="text-sm text-gray-500 mb-3">
                        明日来店予定の予約を一覧表示します。
                    </p>
                    <div class="text-xs text-gray-400">
                        前日準備用に、来店人数やメニュー構成を確認できます。
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
