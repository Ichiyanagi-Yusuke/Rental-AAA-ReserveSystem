<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            データ分析メニュー
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="mb-4 text-sm text-gray-600">
                各種予約データや統計情報を確認できます。
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                {{-- 向こう1週間の予約数 --}}
                <a href="{{ route('analysis.weekly_reservations') }}"
                    class="block bg-white shadow-sm rounded-lg border border-gray-200 hover:border-indigo-400 hover:shadow-md transition p-4">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-semibold text-gray-800">
                            週間予約推移
                        </h3>
                        <span
                            class="inline-flex items-center rounded-full bg-indigo-50 px-2 py-0.5 text-[11px] font-medium text-indigo-700">
                            グラフ・詳細
                        </span>
                    </div>
                    <p class="text-xs text-gray-600 mb-3">
                        本日から向こう1週間の予約件数を折れ線グラフで確認できます。
                    </p>
                    <div class="flex items-center justify-between text-xs text-indigo-600">
                        <span>グラフを表示する</span>
                        <span>→</span>
                    </div>
                </a>

                {{-- ▼ 追加: シーズンサマリ --}}
                <a href="{{ route('analysis.season_summary') }}"
                    class="block bg-white shadow-sm rounded-lg border border-gray-200 hover:border-green-400 hover:shadow-md transition p-4">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-semibold text-gray-800">
                            シーズンサマリ分析
                        </h3>
                        <span
                            class="inline-flex items-center rounded-full bg-green-50 px-2 py-0.5 text-[11px] font-medium text-green-700">
                            統計・集計
                        </span>
                    </div>
                    <p class="text-xs text-gray-600 mb-3">
                        予約数、メニュー比率、男女比、サイズ傾向などの統計情報を確認できます。
                    </p>
                    <div class="flex items-center justify-between text-xs text-green-600">
                        <span>詳細を見る</span>
                        <span>→</span>
                    </div>
                </a>

                {{-- 今後ここに追加可能 --}}
                {{-- 
                <div class="block bg-gray-50 rounded-lg border border-gray-200 p-4 opacity-75">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-semibold text-gray-500">
                            月間売上集計（準備中）
                        </h3>
                    </div>
                    <p class="text-xs text-gray-500">
                        機能追加予定です。
                    </p>
                </div>
                --}}
            </div>
        </div>
    </div>
</x-app-layout>
