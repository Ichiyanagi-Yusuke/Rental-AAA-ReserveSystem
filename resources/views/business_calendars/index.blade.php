<x-app-layout>
    @php
        $user = auth()->user();
        $isMasterUser = $user && in_array((int) $user->role, [0, 1], true);
    @endphp

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            営業カレンダーマスタ
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- フラッシュメッセージ --}}
            @php $status = session('status'); @endphp
            @if ($status)
                @php
                    $type = is_array($status) ? $status['type'] ?? 'success' : 'success';
                    $message = is_array($status) ? $status['message'] ?? '' : $status;
                    $styles = match ($type) {
                        'success' => 'border-green-200 bg-green-50 text-green-800',
                        'error' => 'border-red-200 bg-red-50 text-red-800',
                        default => 'border-gray-200 bg-gray-50 text-gray-800',
                    };
                @endphp
                <div class="mb-4 rounded-md border px-4 py-3 text-sm {{ $styles }}">
                    {{ $message }}
                </div>
            @endif

            {{-- シーズン・月選択フォーム（GET） --}}
            <form method="GET" action="{{ route('business-calendars.index') }}" class="mb-4">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 items-end">
                    {{-- シーズン --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            シーズン
                        </label>
                        <select id="season-year-select" name="season_year"
                            class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach ($seasonYears as $year)
                                <option value="{{ $year }}" @selected($seasonYear == $year)>
                                    {{ $year }} 年シーズン
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- 月 --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            月
                        </label>
                        <select id="month-select" name="month"
                            class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @php
                                $months = $allowedMonths ?? [12, 1, 2, 3, 4];
                            @endphp
                            @foreach ($months as $m)
                                @php
                                    $optionYear = $m === 12 ? $seasonYear : $seasonYear + 1;
                                @endphp
                                <option value="{{ $m }}" @selected($month == $m)>
                                    {{ $optionYear }}年 {{ $m }}月
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- 表示ボタン --}}
                    <div class="flex sm:justify-end">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 mt-2 sm:mt-0 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                            表示
                        </button>
                    </div>
                </div>
            </form>

            {{-- 月単位更新フォーム --}}
            <form method="POST" action="{{ route('business-calendars.update-month') }}">
                @csrf

                {{-- Hidden: シーズン & 月 --}}
                <input type="hidden" name="season_year" value="{{ $seasonYear }}">
                <input type="hidden" name="month" value="{{ $month }}">

                {{-- パターンの凡例 --}}
                <div class="mb-3 flex flex-wrap gap-2 text-xs">
                    @foreach ($patterns as $pattern)
                        <span class="inline-flex items-center rounded-full px-2.5 py-1 border text-gray-700"
                            style="border-color: {{ $pattern->color ?? '#D1D5DB' }}; background-color: {{ $pattern->color ? $pattern->color . '20' : '#F9FAFB' }};">
                            {{ $pattern->name }}
                        </span>
                    @endforeach
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-3 sm:p-4">
                    {{-- カレンダー（日曜始まり） --}}
                    <div class="overflow-x-auto">
                        <table class="w-full text-xs sm:text-sm">
                            <thead>
                                <tr class="bg-gray-100 text-center">
                                    <th class="py-1 sm:py-2 text-red-500 font-medium">日</th>
                                    <th class="py-1 sm:py-2 font-medium">月</th>
                                    <th class="py-1 sm:py-2 font-medium">火</th>
                                    <th class="py-1 sm:py-2 font-medium">水</th>
                                    <th class="py-1 sm:py-2 font-medium">木</th>
                                    <th class="py-1 sm:py-2 font-medium">金</th>
                                    <th class="py-1 sm:py-2 text-blue-500 font-medium">土</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $currentDisplayYear =
                                        $displayYear ?? ($month === 12 ? $seasonYear : $seasonYear + 1);
                                @endphp
                                @foreach ($weeks as $week)
                                    <tr class="border-t">
                                        @foreach ($week as $day)
                                            @php
                                                $isCurrentMonth =
                                                    $day->month == $month && $day->year == $currentDisplayYear;
                                                $dateStr = $day->toDateString();
                                                $calendar = $calendars[$dateStr] ?? null;
                                                $pattern = $calendar?->pattern;
                                            @endphp
                                            <td
                                                class="align-top p-1 sm:p-2 h-20 sm:h-24 {{ $isCurrentMonth ? 'bg-white' : 'bg-gray-50 text-gray-400' }}">
                                                @if ($isCurrentMonth)
                                                    <button type="button"
                                                        class="w-full h-full text-left rounded-md border border-transparent hover:border-indigo-300 hover:bg-indigo-50 p-1 sm:p-2 text-xs sm:text-sm select-calendar-day"
                                                        data-date="{{ $dateStr }}">
                                                        <div class="flex justify-between items-center mb-1">
                                                            <span class="font-semibold">
                                                                {{ $day->day }}
                                                            </span>
                                                        </div>
                                                        <div class="calendar-pattern-label"
                                                            id="pattern-label-{{ $dateStr }}">
                                                            @if ($pattern)
                                                                <span
                                                                    class="inline-flex items-center rounded-full px-2 py-0.5 border text-[10px] sm:text-xs"
                                                                    style="border-color: {{ $pattern->color ?? '#D1D5DB' }}; background-color: {{ $pattern->color ? $pattern->color . '20' : '#F9FAFB' }}; color: #374151;">
                                                                    {{ $pattern->name }}
                                                                </span>
                                                            @else
                                                                <span class="text-[10px] sm:text-xs text-gray-400">
                                                                    未設定
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </button>

                                                    {{-- hidden: 月更新用 --}}
                                                    <input type="hidden"
                                                        name="days[{{ $dateStr }}][business_pattern_id]"
                                                        id="pattern-input-{{ $dateStr }}"
                                                        value="{{ $pattern?->id }}">
                                                @else
                                                    <div class="text-xs text-gray-400">
                                                        {{ $day->day }}
                                                    </div>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- 月単位保存ボタン --}}
                    <div class="mt-4 flex justify-end">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                            この月のカレンダーを保存
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- ▼ 営業パターン選択モーダル --}}
    <div id="pattern-modal" class="fixed inset-0 z-40 hidden">
        {{-- 背景レイヤー（今回は暗さは控えめのまま） --}}
        <div class="absolute inset-0"></div>

        {{-- モーダル本体コンテナ（中央寄せ） --}}
        <div class="relative flex min-h-screen items-center justify-center">
            <div class="bg-white rounded-lg shadow-lg mx-4 sm:mx-auto p-5 sm:p-6"
                style="width: 360px; max-width: 90vw;">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">
                    営業パターン選択
                </h3>
                <p class="text-xs text-gray-500 mb-4" id="modal-date-label"></p>

                {{-- フォーム部分 --}}
                <div class="max-h-60 overflow-y-auto mb-4 space-y-2 px-1 sm:px-2">
                    @foreach ($patterns as $pattern)
                        <label
                            class="flex items-center justify-between text-xs sm:text-sm border rounded-md px-3 py-2 cursor-pointer hover:bg-gray-50">
                            <div class="flex items-center gap-2">
                                <input type="radio" name="modal_business_pattern_id" value="{{ $pattern->id }}"
                                    class="pattern-radio h-3 w-3 sm:h-4 sm:w-4"
                                    data-color="{{ $pattern->color ?? '' }}">
                                <span class="pattern-name">{{ $pattern->name }}</span>
                            </div>
                            @if ($pattern->color)
                                <span class="inline-block h-3 w-3 rounded-full"
                                    style="background-color: {{ $pattern->color }};"></span>
                            @endif
                        </label>
                    @endforeach

                    {{-- クリア（未設定） --}}
                    <label
                        class="flex items-center justify-between text-xs sm:text-sm border rounded-md px-3 py-2 cursor-pointer hover:bg-gray-50">
                        <div class="flex items-center gap-2">
                            <input type="radio" name="modal_business_pattern_id" value=""
                                class="pattern-radio h-3 w-3 sm:h-4 sm:w-4" data-color="">
                            <span class="pattern-name">未設定（クリア）</span>
                        </div>
                    </label>
                </div>

                <div class="flex justify-end gap-2 mt-1 text-xs sm:text-sm">
                    <button type="button" id="modal-cancel-btn"
                        class="px-3 py-1.5 rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">
                        キャンセル
                    </button>
                    <button type="button" id="modal-apply-btn"
                        class="px-3 py-1.5 rounded-md bg-indigo-600 text-white hover:bg-indigo-700">
                        適用
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ▼ JS（モーダル制御 & シーズン変更時の月ラベル更新） --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- モーダル関連 ---
            const modal = document.getElementById('pattern-modal');
            const dateLabel = document.getElementById('modal-date-label');
            const applyBtn = document.getElementById('modal-apply-btn');
            const cancelBtn = document.getElementById('modal-cancel-btn');
            const radios = document.querySelectorAll('.pattern-radio');

            let currentDate = null;

            // 日付クリックでモーダル表示
            document.querySelectorAll('.select-calendar-day').forEach(button => {
                button.addEventListener('click', () => {
                    currentDate = button.getAttribute('data-date');
                    dateLabel.textContent = currentDate + ' の営業パターン';

                    const currentInput = document.getElementById('pattern-input-' + currentDate);
                    const currentPatternId = currentInput ? currentInput.value : '';

                    radios.forEach(radio => {
                        radio.checked = (radio.value === currentPatternId);
                    });

                    modal.classList.remove('hidden');
                });
            });

            function closeModal() {
                modal.classList.add('hidden');
                currentDate = null;
            }

            cancelBtn.addEventListener('click', closeModal);

            // 背景クリックで閉じる（モーダル本体以外をクリックしたとき）
            modal.addEventListener('click', (e) => {
                const content = modal.querySelector('.bg-white.rounded-lg');
                if (content && !content.contains(e.target)) {
                    closeModal();
                }
            });

            // 適用ボタン
            applyBtn.addEventListener('click', () => {
                if (!currentDate) return;

                let selectedValue = '';
                let selectedLabel = '未設定';
                let selectedColor = '';

                radios.forEach(radio => {
                    if (radio.checked) {
                        selectedValue = radio.value;
                        const labelContainer = radio.closest('label');
                        const nameSpan = labelContainer ? labelContainer.querySelector(
                            '.pattern-name') : null;
                        if (nameSpan) {
                            selectedLabel = nameSpan.textContent.trim();
                        }
                        selectedColor = radio.dataset.color || '';
                    }
                });

                const hiddenInput = document.getElementById('pattern-input-' + currentDate);
                const labelElem = document.getElementById('pattern-label-' + currentDate);

                if (hiddenInput) {
                    hiddenInput.value = selectedValue;
                }

                if (labelElem) {
                    if (selectedValue) {
                        // カラーピルを表示（凡例と同じイメージ）
                        const style = selectedColor ?
                            `border-color: ${selectedColor}; background-color: ${selectedColor}20; color: #374151;` :
                            `border-color: #D1D5DB; background-color: #F9FAFB; color: #374151;`;

                        labelElem.innerHTML =
                            `<span class="inline-flex items-center rounded-full px-2 py-0.5 border text-[10px] sm:text-xs" style="${style}">` +
                            selectedLabel +
                            `</span>`;
                    } else {
                        // 未設定
                        labelElem.innerHTML =
                            '<span class="text-[10px] sm:text-xs text-gray-400">未設定</span>';
                    }
                }

                closeModal();
            });

            // --- シーズン変更時に月プルダウン表示を更新 ---
            const seasonSelect = document.getElementById('season-year-select');
            const monthSelect = document.getElementById('month-select');

            if (seasonSelect && monthSelect) {
                seasonSelect.addEventListener('change', function() {
                    const seasonYear = parseInt(this.value, 10);

                    Array.from(monthSelect.options).forEach(option => {
                        const m = parseInt(option.value, 10);
                        if (isNaN(m)) return;

                        const optionYear = (m === 12) ? seasonYear : seasonYear + 1;
                        option.textContent = optionYear + '年 ' + m + '月';
                    });
                });
            }
        });
    </script>
</x-app-layout>
