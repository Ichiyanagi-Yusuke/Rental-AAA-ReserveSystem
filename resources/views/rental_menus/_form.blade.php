{{-- resources/views/rental_menus/_form.blade.php --}}
@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">カテゴリ</label>
        <select name="rental_menu_category_id" class="w-full border-gray-300 rounded-md">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('rental_menu_category_id', $rentalMenu->rental_menu_category_id ?? '') == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('rental_menu_category_id')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">メニュー種別</label>
        <select name="menu_type" class="w-full border-gray-300 rounded-md">
            @foreach ($menuTypes as $value => $label)
                <option value="{{ $value }}" @selected(old('menu_type', $rentalMenu->menu_type ?? 'base') === $value)>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @error('menu_type')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">メニュー名</label>
        <input type="text" name="name" value="{{ old('name', $rentalMenu->name ?? '') }}"
            class="w-full border-gray-300 rounded-md">
        @error('name')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Jrメニュー</label>
        <select name="is_junior" class="w-full border-gray-300 rounded-md">
            <option value="0" @selected(old('is_junior', $rentalMenu->is_junior ?? 0) == 0)>大人向け</option>
            <option value="1" @selected(old('is_junior', $rentalMenu->is_junior ?? 0) == 1)>Jr向け</option>
        </select>
        @error('is_junior')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">基本料金（1日目）</label>
        <input type="number" name="base_price" min="0"
            value="{{ old('base_price', $rentalMenu->base_price ?? '') }}"
            class="w-full border-gray-300 rounded-md text-right">
        @error('base_price')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">連日基本料金（2日目以降）</label>
        <input type="number" name="consecutive_base_price" min="0"
            value="{{ old('consecutive_base_price', $rentalMenu->consecutive_base_price ?? '') }}"
            class="w-full border-gray-300 rounded-md text-right" placeholder="未設定時は基本料金と同じ">
        @error('consecutive_base_price')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">基本割引額</label>
        <input type="number" name="base_discount_amount" min="0"
            value="{{ old('base_discount_amount', $rentalMenu->base_discount_amount ?? 0) }}"
            class="w-full border-gray-300 rounded-md text-right">
        @error('base_discount_amount')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">有効／無効</label>
        <select name="is_active" class="w-full border-gray-300 rounded-md">
            <option value="1" @selected(old('is_active', $rentalMenu->is_active ?? 1) == 1)>有効</option>
            <option value="0" @selected(old('is_active', $rentalMenu->is_active ?? 1) == 0)>無効</option>
        </select>
        @error('is_active')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="mt-4">
    <label class="block text-sm font-medium text-gray-700 mb-1">説明</label>
    <textarea name="description" rows="3" class="w-full border-gray-300 rounded-md">{{ old('description', $rentalMenu->description ?? '') }}</textarea>
    @error('description')
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>

<div class="mt-6 flex justify-end gap-3">
    <a href="{{ route('rental-menus.index') }}"
        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-50">
        戻る
    </a>
    <button type="submit"
        class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-md hover:bg-indigo-700">
        保存する
    </button>
</div>
