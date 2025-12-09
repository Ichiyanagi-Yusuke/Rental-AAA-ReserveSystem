<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ダッシュボード
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- 上部に一言メッセージなど置きたければここに --}}
            <div class="mb-4">
                <p class="text-sm text-gray-600">
                    ようこそ。各種マスタや機能へアクセスできます。
                </p>
            </div>

            {{-- カードレイアウト --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                {{-- マスタ一覧カード --}}
                <a href="{{ route('masters.index') }}"
                    class="flex flex-col justify-between bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-5 hover:shadow-md hover:border-indigo-200 transition">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900">
                                マスタ一覧
                            </h3>
                            <p class="mt-1 text-xs text-gray-500">
                                リゾートマスタなど、各種マスタ管理画面への入口です。
                            </p>
                        </div>
                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-indigo-50">
                            <span class="text-xs font-semibold text-indigo-600">
                                MST
                            </span>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center justify-between text-xs">
                        <span class="inline-flex items-center rounded-full px-2.5 py-1 bg-gray-100 text-gray-600">
                            一覧へ
                        </span>
                        <span class="inline-flex items-center text-indigo-600 font-medium">
                            開く
                            <svg class="ml-1 h-3 w-3" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </span>
                    </div>
                </a>

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

                {{-- 明日の予約カード --}}
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

                {{-- 今後、他機能のカードをここに増やしていける --}}
            </div>
        </div>
    </div>
</x-app-layout>
