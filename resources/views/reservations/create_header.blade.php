<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            予約登録（1/3）代表者情報
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-4 px-4 py-3 rounded-md bg-yellow-50 text-sm text-yellow-800 border border-yellow-200">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('reservations.store.header') }}">
                    @csrf

                    <h3 class="text-sm font-semibold text-gray-800 mb-2">代表者情報</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">性（代表者）</label>
                            <input type="text" name="rep_last_name"
                                value="{{ old('rep_last_name', $header['rep_last_name'] ?? '') }}"
                                class="w-full border-gray-300 rounded-md">
                            @error('rep_last_name')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">名（代表者）</label>
                            <input type="text" name="rep_first_name"
                                value="{{ old('rep_first_name', $header['rep_first_name'] ?? '') }}"
                                class="w-full border-gray-300 rounded-md">
                            @error('rep_first_name')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">せい（ふりがな）</label>
                            <input type="text" name="rep_last_name_kana"
                                value="{{ old('rep_last_name_kana', $header['rep_last_name_kana'] ?? '') }}"
                                class="w-full border-gray-300 rounded-md">
                            @error('rep_last_name_kana')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">めい（ふりがな）</label>
                            <input type="text" name="rep_first_name_kana"
                                value="{{ old('rep_first_name_kana', $header['rep_first_name_kana'] ?? '') }}"
                                class="w-full border-gray-300 rounded-md">
                            @error('rep_first_name_kana')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">電話番号</label>
                            <input type="text" name="phone" value="{{ old('phone', $header['phone'] ?? '') }}"
                                class="w-full border-gray-300 rounded-md">
                            @error('phone')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">メールアドレス</label>
                            <input type="email" name="email" value="{{ old('email', $header['email'] ?? '') }}"
                                class="w-full border-gray-300 rounded-md">
                            @error('email')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <h3 class="text-sm font-semibold text-gray-800 mb-2 mt-4">来店・返却情報</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">来店予定日</label>
                            <input type="date" name="visit_date"
                                value="{{ old('visit_date', $header['visit_date'] ?? '') }}"
                                class="w-full border-gray-300 rounded-md">
                            @error('visit_date')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">来店予定時刻</label>
                            <input type="time" name="visit_time"
                                value="{{ old('visit_time', $header['visit_time'] ?? '') }}"
                                class="w-full border-gray-300 rounded-md">
                            @error('visit_time')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">返却予定日</label>
                            <input type="date" name="return_date"
                                value="{{ old('return_date', $header['return_date'] ?? '') }}"
                                class="w-full border-gray-300 rounded-md">
                            @error('return_date')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="is_last_day_night" value="1" @checked(old('is_last_day_night', $header['is_last_day_night'] ?? false))>
                            <span class="ml-2 text-sm text-gray-700">最終日のナイター利用あり</span>
                        </label>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">利用ゲレンデ</label>
                        <select name="resort_id" class="w-full border-gray-300 rounded-md">
                            <option value="">選択してください</option>
                            @foreach ($resorts as $resort)
                                <option value="{{ $resort->id }}" @selected(old('resort_id', $header['resort_id'] ?? '') == $resort->id)>
                                    {{ $resort->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('resort_id')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">その他ご要望</label>
                        <textarea name="note" rows="3" class="w-full border-gray-300 rounded-md">{{ old('note', $header['note'] ?? '') }}</textarea>
                        @error('note')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="is_terms_agreed" value="1" @checked(old('is_terms_agreed', $header['is_terms_agreed'] ?? true))>
                            <span class="ml-2 text-sm text-gray-700">
                                注意事項を確認し、同意しました。（社内代理入力）
                            </span>
                        </label>
                        @error('is_terms_agreed')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-md hover:bg-indigo-700">
                            利用者情報入力へ進む
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
