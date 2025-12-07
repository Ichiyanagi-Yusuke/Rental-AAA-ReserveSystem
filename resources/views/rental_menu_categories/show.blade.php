<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            レンタルメニューカテゴリ詳細
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6 space-y-4">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
                    <div>
                        <p class="text-sm text-gray-500">名称</p>
                        <p class="text-lg font-semibold">{{ $rentalMenuCategory->name }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        @if ($rentalMenuCategory->is_active)
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
                        <p class="text-gray-500">表示順</p>
                        <p>{{ $rentalMenuCategory->sort_order }}</p>
                    </div>
                </div>

                <div class="pt-4 flex justify-between items-center">
                    <a href="{{ route('rental-menu-categories.index') }}"
                        class="text-sm text-indigo-600 hover:underline">
                        一覧に戻る
                    </a>
                    <a href="{{ route('rental-menu-categories.edit', $rentalMenuCategory) }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-md hover:bg-indigo-700">
                        編集する
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
