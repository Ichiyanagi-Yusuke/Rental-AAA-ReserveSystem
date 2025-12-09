<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            予約内容の確認
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-4 p-3 rounded-md bg-green-50 border border-green-200 text-sm text-green-800">
                    {{ session('status') }}
                </div>
            @endif

            {{-- 代表者情報 --}}
            <div class="mb-6 bg-white shadow-sm sm:rounded-lg p-4 sm:p-6">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-lg font-semibold text-gray-800">代表者情報</h3>
                    <a href="{{ route('reservations.create.header') }}" class="text-sm text-indigo-600 hover:underline">
                        代表者情報を修正する
                    </a>
                </div>

                <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-3 text-sm text-gray-700">
                    <div>
                        <dt class="text-gray-500">お名前</dt>
                        <dd class="font-medium">
                            {{ $header['last_name'] ?? '' }} {{ $header['first_name'] ?? '' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">フリガナ</dt>
                        <dd class="font-medium">
                            {{ $header['last_name_kana'] ?? '' }} {{ $header['first_name_kana'] ?? '' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">電話番号</dt>
                        <dd class="font-medium">
                            {{ $header['phone'] ?? '' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">メールアドレス</dt>
                        <dd class="font-medium">
                            {{ $header['email'] ?? '' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">来店予定日</dt>
                        <dd class="font-medium">
                            {{ $header['visit_date'] ?? '' }} {{ $header['visit_time'] ?? '' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">返却予定日</dt>
                        <dd class="font-medium">
                            {{ $header['return_date'] ?? '' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">ゲレンデ</dt>
                        <dd class="font-medium">
                            {{ $resort->name ?? '未選択' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">最終日のナイター利用</dt>
                        <dd class="font-medium">
                            {{ !empty($header['is_last_night_nighter']) ? '利用する' : '利用しない' }}
                        </dd>
                    </div>
                    <div class="md:col-span-2">
                        <dt class="text-gray-500">その他ご要望</dt>
                        <dd class="font-medium whitespace-pre-wrap">
                            {{ $header['note'] ?? '（なし）' }}
                        </dd>
                    </div>
                </dl>
            </div>

            {{-- 利用者情報（アコーディオン形式） --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-4 sm:p-6 space-y-4 mt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">利用者情報</h3>

                @forelse ($details as $index => $guest)
                    @php
                        // モデルを直接参照（気になる場合は Controller 側で名前を解決して渡す形に後でリファクタしてください）
                        /** @var \App\Models\RentalMenu|null $mainMenu */
                        $mainMenu = !empty($guest['main_gear_menu_id'])
                            ? \App\Models\RentalMenu::find($guest['main_gear_menu_id'])
                            : null;
                        $wearMenu = !empty($guest['wear_menu_id'])
                            ? \App\Models\RentalMenu::find($guest['wear_menu_id'])
                            : null;
                        $gloveMenu = !empty($guest['glove_menu_id'])
                            ? \App\Models\RentalMenu::find($guest['glove_menu_id'])
                            : null;
                        $goggleMenu = !empty($guest['goggle_menu_id'])
                            ? \App\Models\RentalMenu::find($guest['goggle_menu_id'])
                            : null;

                        $genderLabel = match ($guest['gender'] ?? null) {
                            'man' => '男性',
                            'woman' => '女性',
                            'none' => '未回答',
                            default => '',
                        };
                    @endphp

                    <div x-data="{ open: {{ $loop->first ? 'true' : 'false' }} }" class="border border-gray-200 rounded-lg overflow-hidden">
                        {{-- アコーディオンヘッダー --}}
                        <button type="button" @click="open = !open"
                            class="w-full flex items-center justify-between px-4 py-2 bg-gray-50 hover:bg-gray-100">
                            <div class="text-left">
                                <div class="text-sm font-semibold text-gray-800">
                                    利用者 {{ $index + 1 }}：
                                    {{ $guest['guest_name'] ?? '（氏名未入力）' }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $guest['guest_name_kana'] ?? '' }}
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
                                <svg x-show="open" class="w-4 h-4" fill="none" stroke="currentColor"
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
                                        <span>{{ $guest['guest_name'] ?? '' }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium">フリガナ：</span>
                                        <span>{{ $guest['guest_name_kana'] ?? '' }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium">性別：</span>
                                        <span>{{ $genderLabel }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium">区分：</span>
                                        <span>{{ !empty($guest['is_child']) ? '子供' : '大人' }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium">身長：</span>
                                        <span>
                                            {{ $guest['height'] ?? '' }}
                                            @if (!empty($guest['height']))
                                                cm
                                            @endif
                                        </span>
                                    </div>
                                    <div>
                                        <span class="font-medium">足のサイズ：</span>
                                        <span>
                                            {{ $guest['foot_size'] ?? '' }}
                                            @if (!empty($guest['foot_size']))
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
                                        <span>{{ $guest['stance'] ?? '未指定' }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium">Step On：</span>
                                        <span>
                                            @if (!empty($guest['is_step_on']))
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
                                        <span>{{ $guest['wear_size'] ?? '未指定' }}</span>
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
                                        <span>{{ $guest['glove_size'] ?? '未指定' }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium">ヘルメット：</span>
                                        <span>
                                            @if (!empty($guest['is_helmet_used']))
                                                利用する
                                            @else
                                                利用しない
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {{-- ご要望 --}}
                            <div>
                                <h4 class="text-xs font-semibold text-gray-500 mb-1">ご要望</h4>
                                <div class="border border-dashed border-gray-300 rounded-md px-3 py-2 bg-gray-50/60">
                                    @if (!empty($guest['note']))
                                        {{ $guest['note'] }}
                                    @else
                                        <span class="text-gray-400">特になし</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">
                        利用者情報が登録されていません。利用者情報入力画面に戻ってください。
                    </p>
                @endforelse
            </div>

            {{-- ボタンエリア --}}
            <div class="flex flex-col sm:flex-row sm:justify-between gap-3">
                <a href="{{ route('reservations.create.details') }}"
                    class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-700 bg-white hover:bg-gray-50">
                    利用者情報へ戻る
                </a>

                <form method="POST" action="{{ route('reservations.store') }}">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center justify-center px-6 py-2.5 rounded-md bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700"
                        onclick="return confirm('この内容で予約を登録します。よろしいですか？');">
                        この内容で予約を登録する
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
