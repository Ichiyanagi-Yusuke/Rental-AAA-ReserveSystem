<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            営業パターン新規登録
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-4 sm:p-6">

                {{-- バリデーションエラー --}}
                @if ($errors->any())
                    <div class="mb-4 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('business-patterns.store') }}" class="space-y-4">
                    @csrf

                    {{-- コード --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            コード <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="code" value="{{ old('code') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="WEEKDAY, WEEKEND, CLOSED など（半角英数）">
                    </div>

                    {{-- 名称 --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            名称 <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="平日通常営業 など">
                    </div>

                    {{-- 説明 --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            説明
                        </label>
                        <textarea name="description" rows="2"
                            class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="任意で補足説明を入力してください。">{{ old('description') }}</textarea>
                    </div>

                    {{-- 営業/休業 --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            営業区分 <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center gap-4 text-sm">
                            <label class="inline-flex items-center">
                                <input type="radio" name="is_open" value="1"
                                    class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"
                                    {{ old('is_open', '1') == '1' ? 'checked' : '' }}>
                                <span class="ml-2">営業</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="is_open" value="0"
                                    class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"
                                    {{ old('is_open') === '0' ? 'checked' : '' }}>
                                <span class="ml-2">休業</span>
                            </label>
                        </div>
                    </div>

                    {{-- 営業時間 --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                開店時間
                            </label>
                            <input type="time" name="open_time" value="{{ old('open_time') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                閉店時間
                            </label>
                            <input type="time" name="close_time" value="{{ old('close_time') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    {{-- 表示色 --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            カレンダー表示色
                        </label>
                        <input type="text" name="color" value="{{ old('color') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="#3B82F6 のような16進カラーコード">
                        <p class="mt-1 text-[11px] text-gray-500">
                            未入力の場合はデフォルトの色で表示されます。
                        </p>
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <a href="{{ route('business-patterns.index') }}"
                            class="inline-flex items-center px-4 py-2 rounded-md border border-gray-300 bg-white text-sm text-gray-700 hover:bg-gray-50">
                            キャンセル
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 rounded-md bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700">
                            登録する
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
