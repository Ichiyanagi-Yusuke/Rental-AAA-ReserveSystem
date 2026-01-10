<x-app-layout>
    @php
        $reservation = $reservation ?? $detail->reservation;

        $mainMenu = $detail->main_gear_menu_id ? \App\Models\RentalMenu::find($detail->main_gear_menu_id) : null;
        $wearMenu = $detail->wear_menu_id ? \App\Models\RentalMenu::find($detail->wear_menu_id) : null;
        $gloveMenu = $detail->glove_menu_id ? \App\Models\RentalMenu::find($detail->glove_menu_id) : null;
        $goggleMenu = $detail->goggle_menu_id ? \App\Models\RentalMenu::find($detail->goggle_menu_id) : null;

        $genderLabel = match ($detail->gender ?? null) {
            'man' => '男性',
            'woman' => '女性',
            'none' => '未回答',
            default => '',
        };
    @endphp

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            利用者詳細
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- フラッシュメッセージ --}}
            @if (session('status'))
                <div class="p-3 rounded-md bg-blue-50 border border-blue-200 text-sm text-blue-800">
                    {{ session('status') }}
                </div>
            @endif

            {{-- 親予約へのリンク --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-4 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <div class="text-xs text-gray-500">予約情報</div>
                        <div class="text-sm text-gray-800">
                            {{ optional($reservation->visit_date)->format('Y-m-d') ?? $reservation->visit_date }}
                            {{ $reservation->visit_time }}
                            ／ 代表者：
                            {{ $reservation->rep_last_name ?? '' }} {{ $reservation->rep_first_name ?? '' }}
                        </div>
                        <div class="text-xs text-gray-500">
                            ゲレンデ：{{ optional($reservation->resort)->name ?? '未設定' }}
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-2 text-sm">
                        <a href="{{ route('reservations.show', $reservation->id) }}"
                            class="inline-flex items-center px-3 py-1.5 rounded-md border border-gray-300 bg-white hover:bg-gray-50 text-gray-700">
                            予約詳細に戻る
                        </a>
                        <a href="{{ route('reservations.index') }}"
                            class="inline-flex items-center px-3 py-1.5 rounded-md border border-gray-300 bg-white hover:bg-gray-50 text-gray-700">
                            予約一覧へ
                        </a>
                    </div>
                </div>
            </div>

            {{-- 利用者詳細 --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-4 sm:p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">
                            利用者：{{ $detail->guest_name ?? '' }}
                        </h3>
                        <p class="text-sm text-gray-500">
                            {{ $detail->guest_name_kana ?? '' }}
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
                    {{-- 基本情報 --}}
                    <div class="space-y-1">
                        <h4 class="text-xs font-semibold text-gray-500 mb-1">基本情報</h4>
                        <p><span class="font-medium">氏名：</span>{{ $detail->guest_name ?? '' }}</p>
                        <p><span class="font-medium">フリガナ：</span>{{ $detail->guest_name_kana ?? '' }}</p>
                        <p><span class="font-medium">性別：</span>{{ $genderLabel }}</p>
                        <p><span class="font-medium">区分：</span>{{ $detail->is_child ? '子供' : '大人' }}</p>
                        <p>
                            <span class="font-medium">身長：</span>
                            {{ $detail->height }}@if (!is_null($detail->height))
                                cm
                            @endif
                        </p>
                        <p>
                            <span class="font-medium">足のサイズ：</span>
                            {{ $detail->foot_size }}@if (!is_null($detail->foot_size))
                                cm
                            @endif
                        </p>
                    </div>

                    {{-- メインギア --}}
                    <div class="space-y-1">
                        <h4 class="text-xs font-semibold text-gray-500 mb-1">メインギア</h4>
                        <p>
                            <span class="font-medium">プラン：</span>
                            {{ $mainMenu->name ?? '選択なし' }}
                        </p>
                        <p>
                            <span class="font-medium">スタンス：</span>
                            {{ $detail->stance ?: '未指定' }}
                        </p>
                        <p>
                            <span class="font-medium">Step On：</span>
                            {{ $detail->is_step_on ? '利用する' : '利用しない' }}
                        </p>
                    </div>

                    {{-- ウェア --}}
                    <div class="space-y-1">
                        <h4 class="text-xs font-semibold text-gray-500 mb-1">ウェア</h4>
                        <p>
                            <span class="font-medium">プラン：</span>
                            {{ $wearMenu->name ?? '選択なし' }}
                        </p>
                        <p>
                            <span class="font-medium">サイズ：</span>
                            {{ $detail->wear_size ?: '未指定' }}
                        </p>
                    </div>

                    {{-- アクセサリ --}}
                    <div class="space-y-1">
                        <h4 class="text-xs font-semibold text-gray-500 mb-1">アクセサリ</h4>
                        <p>
                            <span class="font-medium">ゴーグル：</span>
                            {{ $goggleMenu->name ?? '選択なし' }}
                        </p>
                        <p>
                            <span class="font-medium">グローブ：</span>
                            {{ $gloveMenu->name ?? '選択なし' }}
                        </p>
                        <p>
                            <span class="font-medium">グローブサイズ：</span>
                            {{ $detail->glove_size ?: '未指定' }}
                        </p>
                        <p>
                            <span class="font-medium">ヘルメット：</span>
                            {{ $detail->is_helmet_used ? '利用する' : '利用しない' }}
                        </p>
                    </div>
                </div>

                {{-- ご要望 --}}
                <div class="pt-2">
                    <h4 class="text-xs font-semibold text-gray-500 mb-1">ご要望</h4>
                    <div
                        class="border border-dashed border-gray-300 rounded-md px-3 py-2 bg-gray-50/60 text-sm text-gray-700">
                        @if (!empty($detail->note))
                            {{ $detail->note }}
                        @else
                            <span class="text-gray-400">特になし</span>
                        @endif
                    </div>
                </div>

                {{-- 削除ボタン（ここだけに配置） --}}
                <div class="pt-4 border-t border-gray-200 flex flex-col sm:flex-row sm:justify-between gap-3">
                    <div class="text-xs text-gray-500">
                        この利用者のみ削除されます。予約自体は残ります。
                    </div>

                    <form method="POST" action="{{ route('reservations.details.destroy', $detail->id) }}"
                        onsubmit="return confirm('この利用者を削除してよろしいですか？');">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 rounded-md bg-red-600 text-white text-sm font-medium hover:bg-red-700">
                            利用者を削除する
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
