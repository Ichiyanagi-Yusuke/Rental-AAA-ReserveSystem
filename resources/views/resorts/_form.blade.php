@php
    /** @var \App\Models\Resort|null $resort */
@endphp

@csrf

<div class="space-y-4">
    {{-- 名称 --}}
    <div>
        <label class="block text-sm font-medium text-gray-700">
            名称 <span class="text-red-500">*</span>
        </label>
        <input type="text" name="name" value="{{ old('name', $resort->name ?? '') }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
        @error('name')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- 料金系 --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">
                通常料金 <span class="text-red-500">*</span>
            </label>
            <input type="number" name="price" min="0" step="1"
                value="{{ old('price', $resort->price ?? 0) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
            @error('price')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">
                休日料金 <span class="text-red-500">*</span>
            </label>
            <input type="number" name="holiday_price" min="0" step="1"
                value="{{ old('holiday_price', $resort->holiday_price ?? 0) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
            @error('holiday_price')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- チケット --}}
    <div>
        <label class="block text-sm font-medium text-gray-700">
            チケット枚数
        </label>
        <input type="number" name="ticket" min="0" step="1"
            value="{{ old('ticket', $resort->ticket ?? 0) }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
        @error('ticket')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- 販売停止フラグ --}}
    <div class="flex items-center">
        <input id="sales_stop" type="checkbox" name="sales_stop" value="1"
            class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
            {{ old('sales_stop', $resort->sales_stop ?? false) ? 'checked' : '' }}>
        <label for="sales_stop" class="ml-2 block text-sm text-gray-700">
            販売停止にする
        </label>
    </div>

    {{-- ボタン --}}
    <div class="flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-2 space-y-2 sm:space-y-0 mt-4">
        <a href="{{ route('resorts.index') }}"
            class="inline-flex justify-center px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-700 bg-white hover:bg-gray-50">
            戻る
        </a>
        <button type="submit"
            class="inline-flex justify-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
            保存
        </button>
    </div>
</div>
