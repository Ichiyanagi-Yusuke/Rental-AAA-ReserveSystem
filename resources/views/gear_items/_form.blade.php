{{-- resources/views/gear_items/_form.blade.php --}}
@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">カテゴリ</label>
        <select name="gear_item_category_id" class="w-full border-gray-300 rounded-md">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('gear_item_category_id', $gearItem->gear_item_category_id ?? '') == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('gear_item_category_id')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">コード</label>
        <input type="text" name="code" value="{{ old('code', $gearItem->code ?? '') }}"
            class="w-full border-gray-300 rounded-md">
        @error('code')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">名称</label>
        <input type="text" name="name" value="{{ old('name', $gearItem->name ?? '') }}"
            class="w-full border-gray-300 rounded-md">
        @error('name')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">サイズ</label>
        <input type="text" name="size_label" value="{{ old('size_label', $gearItem->size_label ?? '') }}"
            class="w-full border-gray-300 rounded-md">
        @error('size_label')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">ブランド</label>
        <input type="text" name="brand" value="{{ old('brand', $gearItem->brand ?? '') }}"
            class="w-full border-gray-300 rounded-md">
        @error('brand')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">モデル名</label>
        <input type="text" name="model_name" value="{{ old('model_name', $gearItem->model_name ?? '') }}"
            class="w-full border-gray-300 rounded-md">
        @error('model_name')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">在庫管理</label>
        <select name="is_stock_managed" class="w-full border-gray-300 rounded-md">
            <option value="1" @selected(old('is_stock_managed', $gearItem->is_stock_managed ?? 1) == 1)>在庫管理する</option>
            <option value="0" @selected(old('is_stock_managed', $gearItem->is_stock_managed ?? 1) == 0)>在庫管理しない</option>
        </select>
        @error('is_stock_managed')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">在庫数</label>
        <input type="number" name="stock_qty" min="0"
            value="{{ old('stock_qty', $gearItem->stock_qty ?? '') }}"
            class="w-full border-gray-300 rounded-md text-right" placeholder="在庫管理しない場合は空でOK">
        @error('stock_qty')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">在庫注意数</label>
        <input type="number" name="stock_warning_threshold" min="0"
            value="{{ old('stock_warning_threshold', $gearItem->stock_warning_threshold ?? '') }}"
            class="w-full border-gray-300 rounded-md text-right" placeholder="任意">
        @error('stock_warning_threshold')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">有効／無効</label>
        <select name="is_active" class="w-full border-gray-300 rounded-md">
            <option value="1" @selected(old('is_active', $gearItem->is_active ?? 1) == 1)>有効</option>
            <option value="0" @selected(old('is_active', $gearItem->is_active ?? 1) == 0)>無効</option>
        </select>
        @error('is_active')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="mt-4">
    <label class="block text-sm font-medium text-gray-700 mb-1">備考</label>
    <textarea name="note" rows="3" class="w-full border-gray-300 rounded-md">{{ old('note', $gearItem->note ?? '') }}</textarea>
    @error('note')
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>

<div class="mt-6 flex justify-end gap-3">
    <a href="{{ route('gear-items.index') }}"
        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-50">
        戻る
    </a>
    <button type="submit"
        class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-md hover:bg-indigo-700">
        保存する
    </button>
</div>
