<x-app-layout>
    @php
        // 代表者名・フリガナ
        $repLast = $reservation->rep_last_name ?? '';
        $repFirst = $reservation->rep_first_name ?? '';
        $repLastK = $reservation->rep_last_name_kana ?? '';
        $repFirstK = $reservation->rep_first_name_kana ?? '';

        // システム関連のユーザー名取得
        // 登録者
        $createdByName = optional($reservation->createdByUser)->name ?? 'システム';
        // 更新者
        $updatedByName = optional($reservation->updatedByUser)->name ?? 'なし';
        // 帳票出力者
        $printedByName = optional($reservation->printedBy)->name ?? '未出力';
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

            {{-- ▼ 追加: キャンセル確認アラートとボタン --}}
            @if ($reservation->trashed() && $reservation->is_cancel_needs_confirmation)
                <div
                    class="bg-gray-100 border-l-4 border-gray-500 p-4 shadow-sm rounded-r-md flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-bold text-gray-800">この予約はキャンセルされています（印刷済み）</h3>
                            <div class="mt-1 text-sm text-gray-700">
                                <p>帳票が出力された後にキャンセルされました。すでに準備済みの機材がある場合は棚に戻し、「回収確認済みにする」ボタンを押してください。</p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('reservations.verify_cancel', $reservation->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="whitespace-nowrap inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            <svg class="mr-2 -ml-1 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            回収確認済みにする
                        </button>
                    </form>
                </div>
            @elseif($reservation->trashed())
                {{-- 確認不要の単なるキャンセルの場合 --}}
                <div class="bg-gray-100 p-4 rounded-md mb-6 text-center text-gray-500 font-bold">
                    この予約はキャンセルされています
                </div>
            @endif
            {{-- ▲ 追加ここまで --}}



            {{-- ▼ 追加: 変更確認アラートとボタン --}}
            @if ($reservation->is_needs_confirmation)
                <div
                    class="bg-red-50 border-l-4 border-red-500 p-4 shadow-sm rounded-r-md flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">予約内容が変更されています</h3>
                            <div class="mt-1 text-sm text-red-700">
                                <p>お客様によって予約内容が更新されました。変更内容を確認し、問題なければ「変更を確認済みにする」ボタンを押してください。</p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('reservations.verify', $reservation->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="whitespace-nowrap inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg class="mr-2 -ml-1 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            変更を確認済みにする
                        </button>
                    </form>
                </div>
            @endif
            {{-- ▲ 追加ここまで --}}

            {{-- ▼ 追加: コメント確認アラートとボタン --}}
            @if (!empty($reservation->note) && !$reservation->is_comment_checked)
                <div
                    class="bg-yellow-50 border-l-4 border-yellow-400 p-4 shadow-sm rounded-r-md flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">ご要望コメントが未確認です</h3>
                            <div class="mt-1 text-sm text-yellow-700">
                                <p>お客様からの要望（note）が入力されています。基本情報欄の「その他ご要望」を確認し、対応可能か等を確認した上で「確認済みにする」ボタンを押してください。</p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('reservations.verify_comment', $reservation->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="whitespace-nowrap inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                            <svg class="mr-2 -ml-1 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            確認済みにする
                        </button>
                    </form>
                </div>
            @endif
            {{-- ▲ 追加ここまで --}}

            {{-- ■基本情報セクション（お客様入力項目） --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-4 sm:p-6">
                <div class="border-b border-gray-200 pb-2 mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">基本情報</h3>
                    <p class="text-xs text-gray-500">お客様に入力いただいた情報です。</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 text-sm text-gray-700">
                    <div class="border-b border-gray-100 pb-2">
                        <span class="block text-gray-400 text-xs">お名前</span>
                        <span class="font-medium text-lg">{{ $repLast }} {{ $repFirst }}</span>
                    </div>
                    <div class="border-b border-gray-100 pb-2">
                        <span class="block text-gray-400 text-xs">フリガナ</span>
                        <span class="font-medium">{{ $repLastK }} {{ $repFirstK }}</span>
                    </div>
                    <div class="border-b border-gray-100 pb-2">
                        <span class="block text-gray-400 text-xs">電話番号</span>
                        <span class="font-medium">{{ $reservation->phone }}</span>
                    </div>
                    <div class="border-b border-gray-100 pb-2">
                        <span class="block text-gray-400 text-xs">メールアドレス</span>
                        <span class="font-medium">{{ $reservation->email }}</span>
                    </div>
                    <div class="border-b border-gray-100 pb-2">
                        <span class="block text-gray-400 text-xs">来店予定日時</span>
                        <span class="font-medium">
                            {{ optional($reservation->visit_date)->format('Y年m月d日') }}
                            {{ optional($reservation->visit_time)->format('H:i') }}
                        </span>
                    </div>
                    <div class="border-b border-gray-100 pb-2">
                        <span class="block text-gray-400 text-xs">返却予定日</span>
                        <span class="font-medium">
                            {{ optional($reservation->return_date)->format('Y年m月d日') }}
                        </span>
                    </div>
                    <div class="border-b border-gray-100 pb-2">
                        <span class="block text-gray-400 text-xs">利用ゲレンデ</span>
                        <span class="font-medium">{{ optional($reservation->resort)->name ?? '未設定' }}</span>
                    </div>
                    <div class="border-b border-gray-100 pb-2">
                        <span class="block text-gray-400 text-xs">最終日ナイター利用</span>
                        <span class="font-medium">{{ $reservation->is_last_day_night ? '利用する' : '利用しない' }}</span>
                    </div>
                    <div class="border-b border-gray-100 pb-2">
                        <span class="block text-gray-400 text-xs">利用規約への同意</span>
                        <span class="font-medium">
                            {{ $reservation->is_terms_agreed ? '同意済み' : '未同意' }}
                        </span>
                    </div>
                </div>

                @if (!empty($reservation->note))
                    <div class="mt-4 pt-2">
                        <span class="block text-gray-400 text-xs mb-1">その他ご要望（代表者）</span>
                        <div
                            class="border border-dashed border-gray-300 rounded-md px-3 py-2 bg-gray-50/50 text-sm text-gray-800">
                            {!! nl2br(e($reservation->note)) !!}
                        </div>
                    </div>
                @endif
            </div>

            {{-- ■システム項目セクション（管理情報） --}}
            <div class="bg-white shadow-inner sm:rounded-lg p-4 sm:p-6 border border-gray-200">
                <div class="border-b border-gray-300 pb-2 mb-4">
                    <h3 class="text-md font-semibold text-gray-600">システム管理項目</h3>
                    <p class="text-xs text-gray-500">システム内部で管理されている情報です。</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-xs text-gray-600">
                    <div>
                        <span class="block text-gray-400">ID</span>
                        <span class="font-mono">{{ $reservation->id }}</span>
                    </div>
                    <div>
                        <span class="block text-gray-400">予約トークン</span>
                        <span class="font-mono break-all">{{ $reservation->token }}</span>
                    </div>
                    <div>
                        <span class="block text-gray-400">管理番号(Build No.)</span>
                        <span class="font-mono">{{ $reservation->build_number ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="block text-gray-400">登録日時</span>
                        <span class="font-mono">{{ $reservation->created_at }}</span>
                    </div>
                    <div>
                        <span class="block text-gray-400">登録者</span>
                        <span class="font-semibold">{{ $createdByName }}</span>
                    </div>
                    <div>
                        <span class="block text-gray-400">最終更新日時</span>
                        <span class="font-mono">{{ $reservation->updated_at }}</span>
                    </div>
                    <div>
                        <span class="block text-gray-400">最終更新者</span>
                        <span class="font-semibold">{{ $updatedByName }}</span>
                    </div>
                    @if ($reservation->deleted_at)
                        <div class="text-red-600">
                            <span class="block text-red-400">削除日時</span>
                            <span class="font-mono">{{ $reservation->deleted_at }}</span>
                        </div>
                    @endif
                    <div>
                        <span class="block text-gray-400">帳票出力日時</span>
                        <span class="font-mono">{{ $reservation->printed_at ?? '未出力' }}</span>
                    </div>
                    <div>
                        <span class="block text-gray-400">帳票出力者</span>
                        <span class="font-semibold">{{ $printedByName }}</span>
                    </div>
                </div>

                <div class="mt-6 flex flex-wrap gap-3 text-sm pt-4 border-t border-gray-200">
                    <a href="{{ route('reservations.index') }}"
                        class="inline-flex items-center px-4 py-2 rounded-md border border-gray-300 bg-white hover:bg-gray-50 text-gray-700 shadow-sm">
                        一覧に戻る
                    </a>
                    <a href="{{ route('reservations.pdf', $reservation->id) }}"
                        class="inline-flex items-center px-4 py-2 rounded-md border border-transparent bg-indigo-600 text-white hover:bg-indigo-700 shadow-sm"
                        target="_blank">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        帳票PDFを出力
                    </a>
                </div>
            </div>

            {{-- 利用者情報（変更なし） --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-4 sm:p-6 space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">利用者情報</h3>

                @forelse ($details as $index => $detail)
                    @php
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
                            class="w-full flex items-center justify-between px-4 py-2 bg-gray-50 hover:bg-gray-100 transition-colors">
                            <div class="text-left">
                                <div class="text-sm font-semibold text-gray-800">
                                    利用者 {{ $index + 1 }}：
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
                                @if ($detail->mainGearMenu)
                                    <span
                                        class="hidden sm:inline bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded text-xs">{{ $detail->mainGearMenu->name }}</span>
                                @endif

                                {{-- ▼ 追加: コメントありバッジ --}}
                                @if (!empty($detail->note))
                                    @if (!$detail->is_comment_checked)
                                        {{-- 未確認の場合: 赤色で目立たせる --}}
                                        <span
                                            class="bg-red-100 text-red-700 px-2 py-0.5 rounded text-xs font-bold whitespace-nowrap">
                                            コメントあり
                                        </span>
                                    @else
                                        {{-- 確認済みの場合: グレーで控えめに --}}
                                        <span
                                            class="hidden sm:inline bg-gray-200 text-gray-600 px-2 py-0.5 rounded text-xs whitespace-nowrap">
                                            コメントあり
                                        </span>
                                    @endif
                                @endif
                                {{-- ▲ 追加ここまで --}}
                                <svg x-show="!open" class="w-4 h-4 text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                                <svg x-show="open" x-cloak class="w-4 h-4 text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7" />
                                </svg>
                            </div>
                        </button>

                        {{-- アコーディオンボディ --}}
                        <div x-show="open" x-cloak class="px-4 pt-3 pb-4 text-sm text-gray-700 space-y-3 bg-white">
                            {{-- 基本情報 --}}
                            <div>
                                <h4 class="text-xs font-semibold text-gray-500 mb-1 border-l-2 border-indigo-400 pl-2">
                                    基本情報</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-1 gap-x-6">
                                    <div class="flex justify-between border-b border-dashed border-gray-100 py-1">
                                        <span class="font-medium text-gray-600">氏名</span>
                                        <span>{{ $detail->guest_name ?? '' }}</span>
                                    </div>
                                    <div class="flex justify-between border-b border-dashed border-gray-100 py-1">
                                        <span class="font-medium text-gray-600">フリガナ</span>
                                        <span>{{ $detail->guest_name_kana ?? '' }}</span>
                                    </div>
                                    <div class="flex justify-between border-b border-dashed border-gray-100 py-1">
                                        <span class="font-medium text-gray-600">性別</span>
                                        <span>{{ $genderLabel }}</span>
                                    </div>
                                    <div class="flex justify-between border-b border-dashed border-gray-100 py-1">
                                        <span class="font-medium text-gray-600">区分</span>
                                        <span>{{ $detail->is_child ? '子供' : '大人' }}</span>
                                    </div>
                                    <div class="flex justify-between border-b border-dashed border-gray-100 py-1">
                                        <span class="font-medium text-gray-600">身長</span>
                                        <span>{{ $detail->height ? $detail->height . ' cm' : '-' }}</span>
                                    </div>
                                    <div class="flex justify-between border-b border-dashed border-gray-100 py-1">
                                        <span class="font-medium text-gray-600">足のサイズ</span>
                                        <span>{{ $detail->foot_size ? $detail->foot_size . ' cm' : '-' }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- メインギア --}}
                            <div class="mt-2">
                                <h4 class="text-xs font-semibold text-gray-500 mb-1 border-l-2 border-indigo-400 pl-2">
                                    メインギア</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-1 gap-x-6">
                                    <div class="flex justify-between border-b border-dashed border-gray-100 py-1">
                                        <span class="font-medium text-gray-600">プラン</span>
                                        <span
                                            class="font-semibold text-gray-800">{{ $detail->mainGearMenu->name ?? '選択なし' }}</span>
                                    </div>
                                    <div class="flex justify-between border-b border-dashed border-gray-100 py-1">
                                        <span class="font-medium text-gray-600">スタンス</span>
                                        <span>{{ $detail->stance ?: '未指定' }}</span>
                                    </div>
                                    <div class="flex justify-between border-b border-dashed border-gray-100 py-1">
                                        <span class="font-medium text-gray-600">Step On</span>
                                        <span>{{ $detail->is_step_on ? '利用する' : '利用しない' }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- ウェア --}}
                            <div class="mt-2">
                                <h4 class="text-xs font-semibold text-gray-500 mb-1 border-l-2 border-indigo-400 pl-2">
                                    ウェア</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-1 gap-x-6">
                                    <div class="flex justify-between border-b border-dashed border-gray-100 py-1">
                                        <span class="font-medium text-gray-600">プラン</span>
                                        <span>{{ $detail->wearMenu->name ?? '選択なし' }}</span>
                                    </div>
                                    <div class="flex justify-between border-b border-dashed border-gray-100 py-1">
                                        <span class="font-medium text-gray-600">サイズ</span>
                                        <span>{{ $detail->wear_size ?: '未指定' }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- アクセサリ --}}
                            <div class="mt-2">
                                <h4 class="text-xs font-semibold text-gray-500 mb-1 border-l-2 border-indigo-400 pl-2">
                                    アクセサリ</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-1 gap-x-6">
                                    <div class="flex justify-between border-b border-dashed border-gray-100 py-1">
                                        <span class="font-medium text-gray-600">ゴーグル</span>
                                        <span>{{ $detail->goggleMenu->name ?? '選択なし' }}</span>
                                    </div>
                                    <div class="flex justify-between border-b border-dashed border-gray-100 py-1">
                                        <span class="font-medium text-gray-600">グローブ</span>
                                        <span>{{ $detail->gloveMenu->name ?? '選択なし' }}</span>
                                    </div>
                                    <div class="flex justify-between border-b border-dashed border-gray-100 py-1">
                                        <span class="font-medium text-gray-600">グローブサイズ</span>
                                        <span>{{ $detail->glove_size ?: '未指定' }}</span>
                                    </div>
                                    <div class="flex justify-between border-b border-dashed border-gray-100 py-1">
                                        <span class="font-medium text-gray-600">ヘルメット</span>
                                        <span>{{ $detail->is_helmet_used ? '利用する' : '利用しない' }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- ご要望 --}}
                            <div class="mt-2">
                                <h4 class="text-xs font-semibold text-gray-500 mb-1 border-l-2 border-indigo-400 pl-2">
                                    ご要望</h4>
                                {{-- ご要望セクション（修正） --}}
                                <div class="mt-2">
                                    <h4
                                        class="text-xs font-semibold text-gray-500 mb-1 border-l-2 border-indigo-400 pl-2">
                                        ご要望</h4>

                                    {{-- 未確認コメントがある場合のアラートとボタン --}}
                                    @if (!empty($detail->note) && !$detail->is_comment_checked)
                                        <div
                                            class="mb-2 p-2 bg-orange-50 border border-orange-200 rounded text-orange-800 text-xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
                                            <span>
                                                <strong>未確認のご要望があります:</strong><br>
                                                {{ $detail->note }}
                                            </span>
                                            <form
                                                action="{{ route('reservations.details.verify_comment', $detail->id) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="whitespace-nowrap bg-orange-600 hover:bg-orange-700 text-white text-xs px-2 py-1 rounded shadow-sm">
                                                    確認済みにする
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        {{-- 通常表示 --}}
                                        <div
                                            class="border border-dashed border-gray-300 rounded-md px-3 py-2 bg-gray-50/60 text-xs">
                                            @if (!empty($detail->note))
                                                {{ $detail->note }}
                                                @if ($detail->is_comment_checked)
                                                    <span class="ml-2 text-green-600 font-bold">（確認済み）</span>
                                                @endif
                                            @else
                                                <span class="text-gray-400">特になし</span>
                                            @endif
                                        </div>
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
