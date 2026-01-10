<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            レンタルメニュー詳細
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ▼ 1枚目：メニュー基本情報カード --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6 space-y-4">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
                    <div>
                        <p class="text-sm text-gray-500">メニュー名</p>
                        <p class="text-lg font-semibold">{{ $rentalMenu->name }}</p>
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                        @if ($rentalMenu->is_junior)
                            <span class="px-2 py-0.5 rounded-full text-xs bg-blue-100 text-blue-800">
                                Jr向け
                            </span>
                        @else
                            <span class="px-2 py-0.5 rounded-full text-xs bg-gray-100 text-gray-800">
                                大人向け
                            </span>
                        @endif

                        @if ($rentalMenu->is_active)
                            <span class="px-2 py-0.5 rounded-full text-xs bg-green-100 text-green-800">
                                有効
                            </span>
                        @else
                            <span class="px-2 py-0.5 rounded-full text-xs bg-gray-200 text-gray-700">
                                無効
                            </span>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500">カテゴリ</p>
                        <p>{{ $rentalMenu->category?->name ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">メニュー種別</p>
                        <p>{{ $rentalMenu->menu_type === 'base' ? 'メインメニュー' : 'オプション' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">基本料金（1日目）</p>
                        <p>¥{{ number_format($rentalMenu->base_price) }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">連日基本料金（2日目以降）</p>
                        <p>
                            @if ($rentalMenu->consecutive_base_price)
                                ¥{{ number_format($rentalMenu->consecutive_base_price) }}
                            @else
                                未設定（基本料金と同じ扱い）
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-500">基本割引額</p>
                        <p>¥{{ number_format($rentalMenu->base_discount_amount) }}</p>
                    </div>
                </div>

                @if ($rentalMenu->description)
                    <div>
                        <p class="text-sm text-gray-500 mb-1">説明</p>
                        <p class="text-sm whitespace-pre-line">{{ $rentalMenu->description }}</p>
                    </div>
                @endif

                <div class="pt-4 flex justify-between items-center">
                    <a href="{{ route('rental-menus.index') }}" class="text-sm text-indigo-600 hover:underline">
                        一覧に戻る
                    </a>

                    @if ($isMasterUser ?? false)
                        <a href="{{ route('rental-menus.edit', $rentalMenu) }}"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-md hover:bg-indigo-700">
                            メニュー情報を編集
                        </a>
                    @endif
                </div>
            </div>

            {{-- ▼ 2枚目：使用ギア構成カード --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6 space-y-4">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
                    <div>
                        <h3 class="text-base font-semibold text-gray-800">
                            使用ギア構成
                        </h3>
                        <p class="text-xs text-gray-500 mt-1">
                            このメニューで利用するギア一覧です。
                        </p>
                    </div>

                    @if ($isMasterUser ?? false)
                        <a href="{{ route('rental-menus.components.edit', $rentalMenu) }}"
                            class="inline-flex items-center px-4 py-2 bg-slate-600 text-white text-sm font-semibold rounded-md hover:bg-slate-700">
                            構成編集
                        </a>
                    @endif
                </div>

                @php
                    $components = $rentalMenu->components ?? collect();
                @endphp

                @if ($components->isEmpty())
                    <p class="text-sm text-gray-500">
                        このメニューに紐づくギアはまだ設定されていません。
                        @if ($isMasterUser ?? false)
                            <br class="hidden sm:block">
                            「構成編集」ボタンから設定してください。
                        @endif
                    </p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="bg-gray-100 text-left">
                                    <th class="px-4 py-2">カテゴリ</th>
                                    <th class="px-4 py-2">名称</th>
                                    <th class="px-4 py-2 hidden sm:table-cell">サイズ</th>
                                    <th class="px-4 py-2 hidden md:table-cell">ブランド / モデル</th>
                                    <th class="px-4 py-2 text-center hidden md:table-cell">在庫管理</th>
                                    <th class="px-4 py-2 text-right hidden md:table-cell">在庫数</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($components as $component)
                                    @php
                                        $gear = $component->gearItem;
                                    @endphp
                                    @if ($gear)
                                        <tr class="border-t">
                                            <td class="px-4 py-2 whitespace-nowrap">
                                                {{ $gear->category?->name ?? '-' }}
                                            </td>
                                            <td class="px-4 py-2">
                                                {{ $gear->name }}
                                            </td>
                                            <td class="px-4 py-2 whitespace-nowrap hidden sm:table-cell">
                                                {{ $gear->size_label ?? '-' }}
                                            </td>
                                            <td class="px-4 py-2 hidden md:table-cell">
                                                @if ($gear->brand || $gear->model_name)
                                                    {{ $gear->brand ?? '' }}
                                                    @if ($gear->brand && $gear->model_name)
                                                        /
                                                    @endif
                                                    {{ $gear->model_name ?? '' }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="px-4 py-2 text-center hidden md:table-cell">
                                                @if ($gear->is_stock_managed)
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 text-xs rounded-full bg-blue-100 text-blue-800">
                                                        管理対象
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-700">
                                                        管理なし
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-2 text-right hidden md:table-cell">
                                                @if ($gear->is_stock_managed)
                                                    {{ $gear->stock_qty ?? 0 }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
