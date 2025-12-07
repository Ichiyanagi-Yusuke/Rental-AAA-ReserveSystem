<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            メニュー構成編集：{{ $rentalMenu->name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 px-4 py-3 rounded-md bg-green-50 text-sm text-green-800 border border-green-200">
                    {{ session('status') }}
                </div>
            @endif

            <div class="mb-4 text-sm text-gray-700">
                <p>カテゴリ：{{ $rentalMenu->category?->name ?? '-' }}</p>
                <p>種別：{{ $rentalMenu->menu_type === 'base' ? 'メインメニュー' : 'オプション' }}</p>
                <p>対象：{{ $rentalMenu->is_junior ? 'Jr向け' : '大人向け' }}</p>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-4 sm:p-6">
                <form action="{{ route('rental-menus.components.update', $rentalMenu) }}" method="POST">
                    @csrf

                    <p class="text-sm text-gray-600 mb-4">
                        このメニューで使用するギアを選択してください。
                    </p>

                    <div class="space-y-6">
                        @foreach ($gearItemsGroup as $categoryName => $items)
                            <div class="border rounded-lg">
                                <div class="px-4 py-2 bg-gray-100 border-b flex items-center justify-between">
                                    <h3 class="text-sm font-semibold text-gray-800">
                                        {{ $categoryName }}
                                    </h3>
                                    <span class="text-xs text-gray-500">
                                        {{ $items->count() }} 件
                                    </span>
                                </div>

                                <div class="px-4 py-3 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
                                    @foreach ($items as $item)
                                        <label
                                            class="flex items-start space-x-2 p-2 rounded-md border border-gray-200 hover:bg-gray-50 cursor-pointer">
                                            <input type="checkbox" name="gear_item_ids[]" value="{{ $item->id }}"
                                                class="mt-1" @checked(in_array($item->id, $selectedGearIds))>
                                            <div class="text-xs sm:text-sm">
                                                <div class="font-semibold text-gray-800">
                                                    {{ $item->name }}
                                                    @if ($item->size_label)
                                                        <span class="text-gray-500 text-xs">
                                                            （{{ $item->size_label }}）
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="text-gray-500 text-xs mt-0.5">
                                                    @if ($item->brand)
                                                        {{ $item->brand }}
                                                    @endif
                                                    @if ($item->model_name)
                                                        / {{ $item->model_name }}
                                                    @endif
                                                </div>
                                                <div class="text-gray-500 text-xs mt-0.5">
                                                    @if ($item->is_stock_managed)
                                                        在庫管理対象
                                                        @if (!is_null($item->stock_qty))
                                                            （在庫 {{ $item->stock_qty }}）
                                                        @endif
                                                    @else
                                                        在庫管理なし
                                                    @endif
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 flex justify-between items-center">
                        <a href="{{ route('rental-menus.show', $rentalMenu) }}"
                            class="text-sm text-indigo-600 hover:underline">
                            メニュー詳細に戻る
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-md hover:bg-indigo-700">
                            構成を保存する
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
