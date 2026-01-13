<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            機能メニュー
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                {{-- 貸出票印刷 --}}
                <a href="{{ route('reservations.print.form') }}"
                    class="block bg-white shadow-sm rounded-lg p-5 hover:bg-gray-50 transition">
                    <h3 class="text-lg font-semibold text-gray-800 mb-1">
                        貸出票印刷
                    </h3>
                    <p class="text-sm text-gray-500 mb-3">
                        本日・明日・期間指定・全ての未印刷分から、貸出票をまとめて印刷します。
                    </p>
                </a>

                {{-- データ分析 --}}
                <a href="{{ route('analysis.index') }}"
                    class="flex flex-col justify-between bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-5 hover:shadow-md hover:border-blue-200 transition">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900">データ分析</h3>
                        <p class="mt-1 text-xs text-gray-500">予約状況の可視化や統計データを確認します。</p>
                    </div>
                    <div class="mt-4 text-xs text-right text-blue-600 font-medium">
                        開く &rarr;
                    </div>
                </a>

                {{-- ブログ管理 --}}
                <a href="{{ route('news-posts.index') }}"
                    class="flex flex-col justify-between bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-5 hover:shadow-md hover:border-green-200 transition">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900">ブログ・お知らせ管理</h3>
                        <p class="mt-1 text-xs text-gray-500">HPに掲載するニュースやブログ記事を作成・編集します。</p>
                    </div>
                    <div class="mt-4 text-xs text-right text-green-600 font-medium">
                        編集する &rarr;
                    </div>
                </a>

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

            </div>
        </div>
    </div>
</x-app-layout>
