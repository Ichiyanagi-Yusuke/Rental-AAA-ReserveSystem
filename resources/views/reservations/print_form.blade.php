<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            貸出票印刷
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('status'))
                <div class="p-3 rounded-md bg-blue-50 border border-blue-200 text-sm text-blue-800">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('reservations.print.execute') }}" x-data="{ mode: 'today' }">
                    @csrf

                    <div class="space-y-4">
                        <p class="text-sm text-gray-700">
                            印刷する予約の範囲を選択してください。（すべて <span class="font-semibold">未印刷分のみ</span> が対象です）
                        </p>

                        {{-- モード選択 --}}
                        <div class="space-y-2 text-sm text-gray-800">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="mode" value="today" x-model="mode"
                                    class="border-gray-300">
                                <span>本日の予約（来店日が本日のもの）</span>
                            </label>

                            <label class="flex items-center gap-2">
                                <input type="radio" name="mode" value="tomorrow" x-model="mode"
                                    class="border-gray-300">
                                <span>明日の予約（来店日が明日のもの）</span>
                            </label>

                            <label class="flex items-center gap-2">
                                <input type="radio" name="mode" value="range" x-model="mode"
                                    class="border-gray-300">
                                <span>期間を指定</span>
                            </label>

                            <div class="pl-6 space-y-2" x-show="mode === 'range'" x-cloak>
                                <div class="flex flex-col sm:flex-row gap-2 items-center text-sm">
                                    <div class="flex items-center gap-2">
                                        <span class="text-gray-500">来店日：</span>
                                        <input type="date" name="from_date" value="{{ old('from_date') }}"
                                            class="border-gray-300 rounded-md text-sm">
                                        <span>〜</span>
                                        <input type="date" name="to_date" value="{{ old('to_date') }}"
                                            class="border-gray-300 rounded-md text-sm">
                                    </div>
                                </div>
                                @error('from_date')
                                    <p class="text-xs text-red-600">{{ $message }}</p>
                                @enderror
                                @error('to_date')
                                    <p class="text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <label class="flex items-center gap-2 pt-2 border-t border-gray-200 mt-2">
                                <input type="radio" name="mode" value="all_unprinted" x-model="mode"
                                    class="border-gray-300">
                                <span>すべての未印刷分</span>
                            </label>
                        </div>

                        @error('mode')
                            <p class="text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <a href="{{ route('dashboard') }}"
                            class="inline-flex items-center px-4 py-2 rounded-md border border-gray-300 bg-white hover:bg-gray-50 text-sm text-gray-700">
                            キャンセル
                        </a>

                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 rounded-md bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700">
                            貸出票を印刷する
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
