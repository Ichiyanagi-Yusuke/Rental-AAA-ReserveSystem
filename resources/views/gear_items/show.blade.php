<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ギア詳細
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6 space-y-4">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
                    <div>
                        <p class="text-sm text-gray-500">名称</p>
                        <p class="text-lg font-semibold">{{ $gearItem->name }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        @if ($gearItem->is_stock_managed)
                            <span class="px-2 py-0.5 rounded-full text-xs bg-blue-100 text-blue-800">
                                在庫管理対象
                            </span>
                        @else
                            <span class="px-2 py-0.5 rounded-full text-xs bg-gray-100 text-gray-800">
                                在庫管理しない
                            </span>
                        @endif

                        @if ($gearItem->is_active)
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
                        <p>{{ $gearItem->category?->name ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">コード</p>
                        <p>{{ $gearItem->code ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">サイズ</p>
                        <p>{{ $gearItem->size_label ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">ブランド</p>
                        <p>{{ $gearItem->brand ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">モデル名</p>
                        <p>{{ $gearItem->model_name ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">在庫数</p>
                        <p>
                            @if ($gearItem->is_stock_managed)
                                {{ $gearItem->stock_qty ?? 0 }}
                            @else
                                -
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-500">在庫注意数</p>
                        <p>
                            @if ($gearItem->is_stock_managed)
                                {{ $gearItem->stock_warning_threshold ?? '-' }}
                            @else
                                -
                            @endif
                        </p>
                    </div>
                </div>

                @if ($gearItem->note)
                    <div>
                        <p class="text-sm text-gray-500 mb-1">備考</p>
                        <p class="text-sm whitespace-pre-line">{{ $gearItem->note }}</p>
                    </div>
                @endif

                <div class="pt-4 flex justify-between items-center">
                    <a href="{{ route('gear-items.index') }}" class="text-sm text-indigo-600 hover:underline">
                        一覧に戻る
                    </a>

                    @if ($isMasterUser ?? false)
                        <a href="{{ route('gear-items.edit', $gearItem) }}"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-md hover:bg-indigo-700">
                            編集する
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
