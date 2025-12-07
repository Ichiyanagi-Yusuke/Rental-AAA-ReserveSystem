<x-app-layout>
    @php
        $user = auth()->user();
        // Role 0,1 をマスタユーザーとする（Resort と同じ基準）
        $isMasterUser = $user && in_array((int) $user->role, [0, 1], true);
    @endphp

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            マスタ一覧
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- 説明 --}}
            <p class="mb-4 text-sm text-gray-600">
                各種マスタの管理画面へのリンクです。ロールに応じて操作可能なマスタが異なります。
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                {{-- 主要リゾートマスタ（Role2 も参照可能） --}}
                <a href="{{ route('resorts.index') }}"
                    class="block bg-white shadow-sm rounded-lg border border-gray-200 hover:border-indigo-400 hover:shadow-md transition p-4">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-semibold text-gray-800">
                            主要リゾートマスタ
                        </h3>
                        <span
                            class="inline-flex items-center rounded-full bg-indigo-50 px-2 py-0.5 text-[11px] font-medium text-indigo-700">
                            一覧・詳細
                        </span>
                    </div>
                    <p class="text-xs text-gray-600 mb-3">
                        主要なスキー場 / リゾートを登録・編集するマスタです。一般ユーザーは参照のみ可能です。
                    </p>
                    <div class="flex items-center justify-between text-xs text-indigo-600">
                        <span>リゾート一覧を開く</span>
                        <span>→</span>
                    </div>
                </a>

                {{-- 営業パターンマスタ（マスタユーザーのみ） --}}
                @if ($isMasterUser)
                    <a href="{{ route('business-patterns.index') }}"
                        class="block bg-white shadow-sm rounded-lg border border-gray-200 hover:border-indigo-400 hover:shadow-md transition p-4">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-sm font-semibold text-gray-800">
                                営業パターンマスタ
                            </h3>
                            <span
                                class="inline-flex items-center rounded-full bg-indigo-50 px-2 py-0.5 text-[11px] font-medium text-indigo-700">
                                一覧・登録・編集
                            </span>
                        </div>
                        <p class="text-xs text-gray-600 mb-3">
                            平日・土日祝・年末年始・休業日など、営業パターンを定義するマスタです。営業カレンダーから利用されます。
                        </p>
                        <div class="flex items-center justify-between text-xs text-indigo-600">
                            <span>営業パターンを管理する</span>
                            <span>→</span>
                        </div>
                    </a>
                @endif

                {{-- 営業カレンダーマスタ（マスタユーザーのみ） --}}
                @if ($isMasterUser)
                    <a href="{{ route('business-calendars.index', ['season_year' => now()->year, 'month' => 12]) }}"
                        class="block bg-white shadow-sm rounded-lg border border-gray-200 hover:border-indigo-400 hover:shadow-md transition p-4">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-sm font-semibold text-gray-800">
                                営業カレンダーマスタ
                            </h3>
                            <span
                                class="inline-flex items-center rounded-full bg-indigo-50 px-2 py-0.5 text-[11px] font-medium text-indigo-700">
                                カレンダー編集
                            </span>
                        </div>
                        <p class="text-xs text-gray-600 mb-3">
                            シーズンごとの営業日・休業日をカレンダー形式で編集します。1ヶ月単位で営業パターンを設定できます。
                        </p>
                        <div class="flex items-center justify-between text-xs text-indigo-600">
                            <span>営業カレンダーを編集する</span>
                            <span>→</span>
                        </div>
                    </a>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
