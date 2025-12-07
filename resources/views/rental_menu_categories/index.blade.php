<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            レンタルメニューカテゴリマスタ
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-4 px-4 py-3 rounded-md bg-green-50 text-sm text-green-800 border border-green-200">
                    {{ session('status') }}
                </div>
            @endif

            <div class="mb-4 flex justify-end">
                <a href="{{ route('rental-menu-categories.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                    新規カテゴリ追加
                </a>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="px-4 py-2">表示順</th>
                            <th class="px-4 py-2">名称</th>
                            <th class="px-4 py-2 text-center">状態</th>
                            <th class="px-4 py-2 text-right">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr class="border-t">
                                <td class="px-4 py-2 whitespace-nowrap">
                                    {{ $category->sort_order }}
                                </td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('rental-menu-categories.show', $category) }}"
                                        class="text-indigo-700 hover:text-indigo-900 no-underline">
                                        {{ $category->name }}
                                    </a>
                                </td>
                                <td class="px-4 py-2 text-center">
                                    @if ($category->is_active)
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
                                    <a href="{{ route('rental-menu-categories.edit', $category) }}"
                                        class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md border border-indigo-500 text-indigo-600 hover:bg-indigo-50 mr-2">
                                        編集
                                    </a>

                                    <form action="{{ route('rental-menu-categories.destroy', $category) }}"
                                        method="POST" class="inline"
                                        onsubmit="return confirm('{{ $category->name }} を削除してよろしいですか？');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md border border-red-500 text-red-600 hover:bg-red-50">
                                            削除
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                                    登録されているカテゴリはありません。
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
