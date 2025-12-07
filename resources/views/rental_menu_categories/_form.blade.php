@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">名称</label>
        <input type="text" name="name" value="{{ old('name', $rentalMenuCategory->name ?? '') }}"
            class="w-full border-gray-300 rounded-md">
        <p class="text-xs text-gray-500 mt-1">
            例）スノーボード、スキー、ウェア など
        </p>
        @error('name')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">表示順</label>
        <input type="number" name="sort_order" min="0"
            value="{{ old('sort_order', $rentalMenuCategory->sort_order ?? 0) }}"
            class="w-full border-gray-300 rounded-md text-right">
        @error('sort_order')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">有効／無効</label>
        <select name="is_active" class="w-full border-gray-300 rounded-md">
            <option value="1" @selected(old('is_active', $rentalMenuCategory->is_active ?? 1) == 1)>有効</option>
            <option value="0" @selected(old('is_active', $rentalMenuCategory->is_active ?? 1) == 0)>無効</option>
        </select>
        @error('is_active')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="mt-6 flex justify-end gap-3">
    <a href="{{ route('rental-menu-categories.index') }}"
        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-50">
        戻る
    </a>
    <button type="submit"
        class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-md hover:bg-indigo-700">
        保存する
    </button>
</div>
