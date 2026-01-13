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
