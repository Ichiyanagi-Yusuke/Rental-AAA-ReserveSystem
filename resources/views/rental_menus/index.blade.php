{{-- resources/views/rental_menus/index.blade.php --}}
<x-app-layout>
    @php
        $isMasterUser = isset($isMasterUser) ? $isMasterUser : false;
    @endphp

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            レンタルメニューマスタ
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 px-4 py-3 rounded-md bg-green-50 text-sm text-green-800 border border-green-200">
                    {{ session('status') }}
                </div>
            @endif

            <div class="mb-4 flex justify-end">
                @if ($isMasterUser)
                    <a href="{{ route('rental-menus.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                        新規メニュー追加
                    </a>
                @endif
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="px-4 py-2">カテゴリ</th>
                            <th class="px-4 py-2">メニュー名</th>
                            <th class="px-4 py-2">種別</th>
                            <th class="px-4 py-2 text-center">Jr</th>
                            <th class="px-4 py-2 text-right">基本料金</th>
                            <th class="px-4 py-2 text-center">状態</th>
                            <th class="px-4 py-2 text-right">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($menus as $menu)
                            <tr class="border-t">
                                <td class="px-4 py-2">
                                    {{ $menu->category?->name ?? '-' }}
                                </td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('rental-menus.show', $menu) }}"
                                        class="text-indigo-700 hover:text-indigo-900 no-underline">
                                        {{ $menu->name }}
                                    </a>
                                </td>
                                <td class="px-4 py-2">
                                    {{ $menu->menu_type === 'base' ? 'メイン' : 'オプション' }}
                                </td>
                                <td class="px-4 py-2 text-center">
                                    {{ $menu->is_junior ? 'Jr' : '大人' }}
                                </td>
                                <td class="px-4 py-2 text-right">
                                    ¥{{ number_format($menu->base_price) }}
                                </td>
                                <td class="px-4 py-2 text-center">
                                    @if ($menu->is_active)
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            有効
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 text-xs font-semibold rounded-full bg-gray-200 text-gray-700">
                                            無効
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-right whitespace-nowrap">
                                    @if ($isMasterUser)
                                        <a href="{{ route('rental-menus.edit', $menu) }}"
                                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md border border-indigo-500 text-indigo-600 hover:bg-indigo-50 mr-2">
                                            編集
                                        </a>

                                        <form action="{{ route('rental-menus.destroy', $menu) }}" method="POST"
                                            class="inline"
                                            onsubmit="return confirm('{{ $menu->name }} を削除してよろしいですか？');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md border border-red-500 text-red-600 hover:bg-red-50">
                                                削除
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-400 text-xs">参照のみ</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                                    登録されているメニューはありません。
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $menus->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
