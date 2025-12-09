<x-app-layout>
    @php
        $repLast = $reservation->rep_last_name ?? '';
        $repFirst = $reservation->rep_first_name ?? '';
        $repLastK = $reservation->rep_last_name_kana ?? '';
        $repFirstK = $reservation->rep_first_name_kana ?? '';
    @endphp

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            予約詳細
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

            {{-- 予約ヘッダー情報 --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-4 sm:p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">代表者・予約情報</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-2 text-sm text-gray-700">
                    <div>
                        <span class="text-gray-500">お名前：</span>
                        <span>{{ $repLast }} {{ $repFirst }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">フリガナ：</span>
                        <span>{{ $repLastK }} {{ $repFirstK }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">電話番号：</span>
                        <span>{{ $reservation->phone }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">メールアドレス：</span>
                        <span>{{ $reservation->email }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">来店日：</span>
                        <span>
                            {{ optional($reservation->visit_date)->format('Y-m-d') ?? $reservation->visit_date }}
                            {{ $reservation->visit_time }}
                        </span>
                    </div>
                    <div>
                        <span class="text-gray-500">返却予定日：</span>
                        <span>
                            {{ optional($reservation->return_date)->format('Y-m-d') ?? $reservation->return_date }}
                        </span>
                    </div>
                    <div>
                        <span class="text-gray-500">ゲレンデ：</span>
                        <span>{{ optional($reservation->resort)->name ?? '未設定' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">最終日ナイター利用：</span>
                        <span>{{ $reservation->is_night_use ? '利用する' : '利用しない' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">予約トークン：</span>
                        <span class="text-xs break-all">{{ $reservation->token }}</span>
                    </div>
                </div>

                @if (!empty($reservation->note))
                    <div class="mt-4">
                        <span class="block text-gray-500 text-sm mb-1">その他ご要望（代表者）</span>
                        <div
                            class="border border-dashed border-gray-300 rounded-md px-3 py-2 bg-gray-50/60 text-sm text-gray-700">
                            {{ $reservation->note }}
                        </div>
                    </div>
                @endif

                <div class="mt-4 flex flex-wrap gap-3 text-sm">
                    <a href="{{ route('reservations.index') }}"
                        class="inline-flex items-center px-4 py-2 rounded-md border border-gray-300 bg-white hover:bg-gray-50 text-gray-700">
                        一覧に戻る
                    </a>
                    {{-- 必要であれば「予約編集」「帳票出力」などのボタンをここに足せます --}}
                </div>
            </div>

            {{-- 利用者情報（アコーディオン・最初は全て閉じる） --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-4 sm:p-6 space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">利用者情報</h3>

                @forelse ($details as $index => $detail)
                    @php
                        $mainMenu = $detail->main_gear_menu_id
                            ? \App\Models\RentalMenu::find($detail->main_gear_menu_id)
                            : null;
                        $wearMenu = $detail->wear_menu_id ? \App\Models\RentalMenu::find($detail->wear_menu_id) : null;
                        $gloveMenu = $detail->glove_menu_id
                            ? \App\Models\RentalMenu::find($detail->glove_menu_id)
                            : null;
                        $goggleMenu = $detail->goggle_menu_id
                            ? \App\Models\RentalMenu::find($detail->goggle_menu_id)
                            : null;

                        $genderLabel = match ($detail->gender ?? null) {
                            'man' => '男性',
                            'woman' => '女性',
                            'none' => '未回答',
                            default => '',
                        };
                    @endphp

                    <div x-data="{ open: false }" class="border border-gray-200 rounded-lg overflow-hidden">
                        {{-- アコーディオンヘッダー --}}
                        <button type="button" @click="open = !open"
                            class="w-full flex items-center justify-between px-4 py-2 bg-gray-50 hover:bg-gray-100">
                            <div class="text-left">
                                <div class="text-sm font-semibold text-gray-800">
                                    利用者 {{ $index + 1 }}：
                                    {{-- ★ 名前をクリックで個別詳細へ --}}
                                    <a href="{{ route('reservations.details.show', [$reservation->id, $detail->id]) }}"
                                        class="text-indigo-600 hover:underline">
                                        {{ $detail->guest_name ?? '（氏名未入力）' }}
                                    </a>
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $detail->guest_name_kana ?? '' }}
                                </div>
                            </div>
                            <div class="flex items-center gap-3 text-xs text-gray-500">
                                @if ($mainMenu)
                                    <span class="hidden sm:inline">{{ $mainMenu->name }}</span>
                                @endif
                                <svg x-show="!open" class="w-4 h-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                                <svg x-show="open" x-cloak class="w-4 h-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7" />
                                </svg>
                            </div>
                        </button>

                        {{-- アコーディオンボディ --}}
                        <div x-show="open" x-cloak class="px-4 pt-3 pb-4 text-sm text-gray-700 space-y-3">
                            {{-- 基本情報 --}}
                            <div>
                                <h4 class="text-xs font-semibold text-gray-500 mb-1">基本情報</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-1 gap-x-6">
                                    <div>
                                        <span class="font-medium">氏名：</span>
                                        <span>{{ $detail->guest_name ?? '' }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium">フリガナ：</span>
                                        <span>{{ $detail->guest_name_kana ?? '' }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium">性別：</span>
                                        <span>{{ $genderLabel }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium">区分：</span>
                                        <span>{{ $detail->is_child ? '子供' : '大人' }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium">身長：</span>
                                        <span>
                                            {{ $detail->height }}
                                            @if (!is_null($detail->height))
                                                cm
                                            @endif
                                        </span>
                                    </div>
                                    <div>
                                        <span class="font-medium">足のサイズ：</span>
                                        <span>
                                            {{ $detail->foot_size }}
                                            @if (!is_null($detail->foot_size))
                                                cm
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {{-- メインギア --}}
                            <div>
                                <h4 class="text-xs font-semibold text-gray-500 mb-1">メインギア</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-1 gap-x-6">
                                    <div>
                                        <span class="font-medium">プラン：</span>
                                        <span>{{ $mainMenu->name ?? '選択なし' }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium">スタンス：</span>
                                        <span>{{ $detail->stance ?: '未指定' }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium">Step On：</span>
                                        <span>
                                            @if ($detail->is_step_on)
                                                利用する
                                            @else
                                                利用しない
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {{-- ウェア --}}
                            <div>
                                <h4 class="text-xs font-semibold text-gray-500 mb-1">ウェア</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-1 gap-x-6">
                                    <div>
                                        <span class="font-medium">プラン：</span>
                                        <span>{{ $wearMenu->name ?? '選択なし' }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium">サイズ：</span>
                                        <span>{{ $detail->wear_size ?: '未指定' }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- アクセサリ --}}
                            <div>
                                <h4 class="text-xs font-semibold text-gray-500 mb-1">アクセサリ</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-1 gap-x-6">
                                    <div>
                                        <span class="font-medium">ゴーグル：</span>
                                        <span>{{ $goggleMenu->name ?? '選択なし' }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium">グローブ：</span>
                                        <span>{{ $gloveMenu->name ?? '選択なし' }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium">グローブサイズ：</span>
                                        <span>{{ $detail->glove_size ?: '未指定' }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium">ヘルメット：</span>
                                        <span>{{ $detail->is_helmet_used ? '利用する' : '利用しない' }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- ご要望 --}}
                            <div>
                                <h4 class="text-xs font-semibold text-gray-500 mb-1">ご要望</h4>
                                <div class="border border-dashed border-gray-300 rounded-md px-3 py-2 bg-gray-50/60">
                                    @if (!empty($detail->note))
                                        {{ $detail->note }}
                                    @else
                                        <span class="text-gray-400">特になし</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">
                        利用者情報が登録されていません。
                    </p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
