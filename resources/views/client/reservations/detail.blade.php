<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="color-scheme" content="light" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            color-scheme: light !important;
        }

        body {
            background: #f5f5f5;
            min-height: 100vh;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            padding: 0;
        }

        .main-container {
            max-width: 800px;
            margin: 0 auto;
            background: #ffffff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            min-height: 100vh;
        }

        .logo-section {
            padding: 2rem 1rem;
            text-align: center;
            border-bottom: 3px solid #e63946;
            position: relative;
        }

        .logo-section::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: #ffffff;
        }

        .logo-section img {
            max-width: 300px;
            width: 100%;
            height: auto;
        }

        .logo-section h4 {
            color: #1a1a1a;
            font-weight: 700;
            letter-spacing: 0.1em;
            margin-top: 1rem;
            font-size: 2rem;
        }

        .form-wrapper {
            background: #fafafa;
            padding: 2.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-size: 0.9rem;
            color: #2d2d2d;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 0.5rem;
            border: none;
            border-bottom: 2px solid #e5e5e5;
            background: #f8f8f8;
            font-size: 1rem;
            color: #1a1a1a;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-control:focus {
            outline: none;
            border-bottom: 2px solid #e63946;
        }

        .form-control::placeholder {
            color: #999999;
        }

        textarea.form-control {
            min-height: 80px;
            resize: vertical;
            border: 1px solid #e5e5e5;
            padding: 0.75rem;
        }

        textarea.form-control:focus {
            border: 1px solid #e63946;
        }

        select.form-control {
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%232d2d2d' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.5rem center;
            padding-right: 2rem;
        }

        .checkbox-group {
            margin-bottom: 1.5rem;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            background: #f8f8f8;
            border-bottom: 2px solid #e5e5e5;
        }

        .checkbox-wrapper input[type="checkbox"] {
            width: 20px;
            height: 20px;
            margin-right: 0.75rem;
            cursor: pointer;
            accent-color: #e63946;
        }

        .checkbox-wrapper label {
            font-size: 1rem;
            color: #2d2d2d;
            font-weight: 600;
            cursor: pointer;
            margin: 0;
        }

        .error-msg {
            color: #e63946;
            font-size: 0.85rem;
            margin-top: 0.3rem;
            display: block;
            font-weight: 600;
            min-height: 1.2rem;
        }

        .hidden {
            display: none !important;
        }

        .button-container {
            display: flex;
            gap: 1rem;
            justify-content: center;
            padding: 2rem;
            border-top: 2px solid #e5e5e5;
            background: #ffffff;
            flex-wrap: wrap;
        }

        .btn {
            padding: 1rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            letter-spacing: 0.05em;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 140px;
            cursor: pointer;
        }

        .btn-back {
            background: #ffffff;
            color: #1a1a1a;
            border: 2px solid #2d2d2d;
        }

        .btn-back:hover {
            background: #2d2d2d;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }

        .btn-submit {
            background: #e63946;
            color: #ffffff;
        }

        .btn-submit:hover:not(.disabled) {
            background: #d62839;
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(230, 57, 70, 0.4);
        }

        .btn.disabled {
            background: #cccccc;
            color: #666666;
            cursor: not-allowed;
            border: none;
        }

        .btn.disabled:hover {
            background: #cccccc;
            transform: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .hide-on-mobile {
            display: block;
        }

        .hide-on-desktop {
            display: none;
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem 0.5rem;
            }

            .logo-section h4 {
                font-size: 1.5rem;
            }

            .form-wrapper {
                padding: 1.5rem;
            }

            .button-container {
                flex-direction: column;
                padding: 1.5rem;
            }

            .btn {
                width: 100%;
                padding: 0.8rem 1.5rem;
            }

            .hide-on-mobile {
                display: none;
            }

            .hide-on-desktop {
                display: block;
            }
        }
    </style>
</head>

<body>
    <div class="main-container">
        <div class="logo-section">
            <img src="{{ asset('images/client/header-logo.png') }}" alt="ロゴ">
            <h4>利用者情報</h4>
        </div>

        <div class="form-wrapper">
            <form action="{{ route('client.reservation.detail.store') }}" method="post" id="mainform" name="mainform">
                @csrf

                @foreach ($details as $index => $detail)
                    <div class="guest-section" data-index="{{ $index }}">
                        <input type="hidden" name="guests[{{ $index }}][jr]" value="0">
                        <div class="checkbox-group">
                            <div class="checkbox-wrapper">
                                <input type="checkbox" name="guests[{{ $index }}][jr]" value="1"
                                    id="jr_{{ $index }}"
                                    {{ old("guests.$index.jr", $detail['jr'] ?? false) ? 'checked' : '' }}>
                                <label for="jr_{{ $index }}">中学生以下</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name_{{ $index }}">利用者名</label>
                            <input id="name_{{ $index }}" type="text" class="form-control name-input"
                                placeholder="山田太郎" maxlength="20" name="guests[{{ $index }}][name]"
                                value="{{ old("guests.$index.name", $detail['name'] ?? '') }}">
                            <span class="error-msg name-error">
                                @error("guests.$index.name")
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="furigana_{{ $index }}">フリガナ</label>
                            <input id="furigana_{{ $index }}" type="text" class="form-control furigana-input"
                                placeholder="ヤマダタロウ" maxlength="20" name="guests[{{ $index }}][furigana]"
                                value="{{ old("guests.$index.furigana", $detail['furigana'] ?? '') }}">
                            <span class="error-msg furigana-error">
                                @error("guests.$index.furigana")
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="sex_{{ $index }}">性別</label>
                            <select class="form-control sex-input" id="sex_{{ $index }}"
                                name="guests[{{ $index }}][sex]">
                                <option value="">性別を選択</option>
                                <option value="0"
                                    {{ old("guests.$index.sex", $detail['sex'] ?? '') == '0' ? 'selected' : '' }}>女性
                                </option>
                                <option value="1"
                                    {{ old("guests.$index.sex", $detail['sex'] ?? '') == '1' ? 'selected' : '' }}>男性
                                </option>
                                <option value="2"
                                    {{ old("guests.$index.sex", $detail['sex'] ?? '') == '2' ? 'selected' : '' }}>回答しない
                                </option>
                            </select>
                            <span class="error-msg sex-error">
                                @error("guests.$index.sex")
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="tall_{{ $index }}">身長(cm)</label>
                            <input id="tall_{{ $index }}" type="number" class="form-control tall-input"
                                placeholder="170" name="guests[{{ $index }}][tall]"
                                value="{{ old("guests.$index.tall", $detail['tall'] ?? '') }}">
                            <span class="error-msg tall-error">
                                @error("guests.$index.tall")
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="foot_{{ $index }}">足の大きさ</label>
                            <select class="form-control foot-input" id="foot_{{ $index }}"
                                name="guests[{{ $index }}][foot]">
                                <option value="">足の大きさ</option>
                                @for ($i = 15.5; $i < 32.0; $i = $i + 0.5)
                                    <option value="{{ $i }}"
                                        {{ old("guests.$index.foot", $detail['foot'] ?? '') == $i ? 'selected' : '' }}>
                                        {{ $i }} cm
                                    </option>
                                @endfor
                            </select>
                            <span class="error-msg foot-error">
                                @error("guests.$index.foot")
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="gear_plan_id_{{ $index }}">メインギア</label>
                            <select class="form-control gear-input" id="gear_plan_id_{{ $index }}"
                                name="guests[{{ $index }}][gear_plan_id]" data-category-id="{{ $boardCategoryId }}">
                                <option value="">利用しない</option>
                                @foreach ($gear_plans_adult as $gear_plan)
                                    <option value="{{ $gear_plan->id }}" class="gear-adult" data-category="{{ $gear_plan->rental_menu_category_id }}"
                                        {{ old("guests.$index.gear_plan_id", $detail['gear_plan_id'] ?? '') == $gear_plan->id ? 'selected' : '' }}>
                                        {{ $gear_plan->name }}
                                    </option>
                                @endforeach
                                @foreach ($gear_plans_child as $gear_plan)
                                    <option value="{{ $gear_plan->id }}" class="gear-child" style="display:none;" data-category="{{ $gear_plan->rental_menu_category_id }}"
                                        {{ old("guests.$index.gear_plan_id", $detail['gear_plan_id'] ?? '') == $gear_plan->id ? 'selected' : '' }}>
                                        {{ $gear_plan->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group stance-group hidden">
                            <label for="stance_id_{{ $index }}">スタンス</label>
                            <select class="form-control" id="stance_id_{{ $index }}"
                                name="guests[{{ $index }}][stance_id]">
                                <option value="">選択して下さい。</option>
                                @foreach ($stances as $stance)
                                    <option value="{{ $stance->id }}"
                                        {{ old("guests.$index.stance_id", $detail['stance_id'] ?? '') == $stance->id ? 'selected' : '' }}>
                                        {{ $stance->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <input type="hidden" name="guests[{{ $index }}][is_step_on]" value="0">
                        <div class="checkbox-group step-on-group hidden">
                            <div class="checkbox-wrapper">
                                <input type="checkbox" name="guests[{{ $index }}][is_step_on]" value="1"
                                    id="is_step_on_{{ $index }}"
                                    {{ old("guests.$index.is_step_on", $detail['is_step_on'] ?? false) ? 'checked' : '' }}>
                                <label for="is_step_on_{{ $index }}">Step On利用</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="wear_plan_id_{{ $index }}">レンタルウェア</label>
                            <select class="form-control wear-input" id="wear_plan_id_{{ $index }}"
                                name="guests[{{ $index }}][wear_plan_id]">
                                <option value="">利用しない</option>
                                @foreach ($wear_plans_adult as $wear_plan)
                                    <option value="{{ $wear_plan->id }}" class="wear-adult"
                                        {{ old("guests.$index.wear_plan_id", $detail['wear_plan_id'] ?? '') == $wear_plan->id ? 'selected' : '' }}>
                                        {{ $wear_plan->name }}
                                    </option>
                                @endforeach
                                @foreach ($wear_plans_child as $wear_plan)
                                    <option value="{{ $wear_plan->id }}" class="wear-child" style="display:none;"
                                        {{ old("guests.$index.wear_plan_id", $detail['wear_plan_id'] ?? '') == $wear_plan->id ? 'selected' : '' }}>
                                        {{ $wear_plan->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group wear-size-group hidden">
                            <label for="wear_size_{{ $index }}">ウェアサイズ</label>
                            <select class="form-control" id="wear_size_{{ $index }}"
                                name="guests[{{ $index }}][wear_size]">
                                <option value="">ウェアサイズ</option>
                                <option value="100"
                                    {{ old("guests.$index.wear_size", $detail['wear_size'] ?? '') == '100' ? 'selected' : '' }}>
                                    100</option>
                                <option value="110"
                                    {{ old("guests.$index.wear_size", $detail['wear_size'] ?? '') == '110' ? 'selected' : '' }}>
                                    110</option>
                                <option value="120"
                                    {{ old("guests.$index.wear_size", $detail['wear_size'] ?? '') == '120' ? 'selected' : '' }}>
                                    120</option>
                                <option value="130"
                                    {{ old("guests.$index.wear_size", $detail['wear_size'] ?? '') == '130' ? 'selected' : '' }}>
                                    130</option>
                                <option value="140"
                                    {{ old("guests.$index.wear_size", $detail['wear_size'] ?? '') == '140' ? 'selected' : '' }}>
                                    140</option>
                                <option value="150"
                                    {{ old("guests.$index.wear_size", $detail['wear_size'] ?? '') == '150' ? 'selected' : '' }}>
                                    150</option>
                                <option value="S"
                                    {{ old("guests.$index.wear_size", $detail['wear_size'] ?? '') == 'S' ? 'selected' : '' }}>
                                    S</option>
                                <option value="M"
                                    {{ old("guests.$index.wear_size", $detail['wear_size'] ?? '') == 'M' ? 'selected' : '' }}>
                                    M</option>
                                <option value="L"
                                    {{ old("guests.$index.wear_size", $detail['wear_size'] ?? '') == 'L' ? 'selected' : '' }}>
                                    L</option>
                                <option value="XL"
                                    {{ old("guests.$index.wear_size", $detail['wear_size'] ?? '') == 'XL' ? 'selected' : '' }}>
                                    XL</option>
                                <option value="XXL"
                                    {{ old("guests.$index.wear_size", $detail['wear_size'] ?? '') == 'XXL' ? 'selected' : '' }}>
                                    XXL</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="glove_plan_id_{{ $index }}">レンタルグローブ</label>
                            <select class="form-control glove-input" id="glove_plan_id_{{ $index }}"
                                name="guests[{{ $index }}][glove_plan_id]">
                                <option value="">利用しない</option>
                                @foreach ($glove_plans_adult as $glove_plan)
                                    <option value="{{ $glove_plan->id }}" class="glove-adult"
                                        {{ old("guests.$index.glove_plan_id", $detail['glove_plan_id'] ?? '') == $glove_plan->id ? 'selected' : '' }}>
                                        {{ $glove_plan->name }}
                                    </option>
                                @endforeach
                                @foreach ($glove_plans_child as $glove_plan)
                                    <option value="{{ $glove_plan->id }}" class="glove-child" style="display:none;"
                                        {{ old("guests.$index.glove_plan_id", $detail['glove_plan_id'] ?? '') == $glove_plan->id ? 'selected' : '' }}>
                                        {{ $glove_plan->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group glove-size-group hidden">
                            <label for="glove_size_{{ $index }}">グローブサイズ</label>
                            <select class="form-control" id="glove_size_{{ $index }}"
                                name="guests[{{ $index }}][glove_size]">
                                <option value="">グローブサイズ</option>
                                <option value="S"
                                    {{ old("guests.$index.glove_size", $detail['glove_size'] ?? '') == 'S' ? 'selected' : '' }}>
                                    S</option>
                                <option value="M"
                                    {{ old("guests.$index.glove_size", $detail['glove_size'] ?? '') == 'M' ? 'selected' : '' }}>
                                    M</option>
                                <option value="L"
                                    {{ old("guests.$index.glove_size", $detail['glove_size'] ?? '') == 'L' ? 'selected' : '' }}>
                                    L</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="goggles_plan_id_{{ $index }}">レンタルゴーグル</label>
                            <select class="form-control" id="goggles_plan_id_{{ $index }}"
                                name="guests[{{ $index }}][goggles_plan_id]">
                                <option value="">利用しない</option>
                                @foreach ($goggles_plans_adult as $goggles_plan)
                                    <option value="{{ $goggles_plan->id }}" class="goggle-adult"
                                        {{ old("guests.$index.goggles_plan_id", $detail['goggles_plan_id'] ?? '') == $goggles_plan->id ? 'selected' : '' }}>
                                        {{ $goggles_plan->name }}
                                    </option>
                                @endforeach
                                @foreach ($goggles_plans_child as $goggles_plan)
                                    <option value="{{ $goggles_plan->id }}" class="goggle-child" style="display:none;"
                                        {{ old("guests.$index.goggles_plan_id", $detail['goggles_plan_id'] ?? '') == $goggles_plan->id ? 'selected' : '' }}>
                                        {{ $goggles_plan->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <input type="hidden" name="guests[{{ $index }}][helmet]" value="0">
                        <div class="checkbox-group">
                            <div class="checkbox-wrapper">
                                <input type="checkbox" name="guests[{{ $index }}][helmet]" value="1"
                                    id="helmet_{{ $index }}"
                                    {{ old("guests.$index.helmet", $detail['helmet'] ?? false) ? 'checked' : '' }}>
                                <label for="helmet_{{ $index }}">ヘルメット</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="comment_{{ $index }}">個別のご要望</label>
                            <textarea id="comment_{{ $index }}" class="form-control" name="guests[{{ $index }}][comment]"
                                placeholder="個別のご要望があればご記入ください">{{ old("guests.$index.comment", $detail['comment'] ?? '') }}</textarea>
                        </div>

                        @if ($index > 0)
                            <hr style="margin: 2rem 0; border: none; border-top: 2px solid #e5e5e5;">
                        @endif
                    </div>
                @endforeach
            </form>
        </div>

        <div class="button-container">
            @if (request()->query('edit') !== 'single' && request()->query('from_confirm') !== 'add')
                <a href="{{ route('client.reservation.header') }}" class="btn btn-back hide-on-mobile">戻る</a>
            @endif
            @if (request()->query('edit') !== 'single' && request()->query('from_confirm') !== 'add')
                <a href="#" onclick="submitWithAction('add_guest'); return false;" id="submit-tag"
                    class="btn btn-submit">利用者を追加</a>
            @endif
            <a href="#" onclick="submitWithAction('confirm'); return false;" id="submit-tag-sub"
                class="btn btn-submit">確認画面へ</a>
            @if (request()->query('edit') !== 'single' && request()->query('from_confirm') !== 'add')
                <a href="{{ route('client.reservation.header') }}" class="btn btn-back hide-on-desktop">戻る</a>
            @endif
        </div>
    </div>

    <script>
        function submitWithAction(actionType) {
            const form = document.forms['mainform'];
            if (form) {
                // 既存のaction inputがあれば削除
                const existingInput = form.querySelector('input[name="action"]');
                if (existingInput) {
                    existingInput.remove();
                }

                // 新しいaction inputを追加
                const actionInput = document.createElement('input');
                actionInput.type = 'hidden';
                actionInput.name = 'action';
                actionInput.value = actionType;
                form.appendChild(actionInput);

                // フォームを送信
                form.action = '{{ route('client.reservation.detail.store') }}';
                form.submit();
            }
        }

        document.addEventListener("DOMContentLoaded", () => {
            const form = document.getElementById("mainform");
            const submitButton = document.getElementById("submit-tag");
            const submitButton2 = document.getElementById("submit-tag-sub");

            // 各入力の初期バリデーション
            document.querySelectorAll('.guest-section').forEach((section) => {
                const index = section.dataset.index;

                // 子供チェックボックス変更時の処理
                const jrCheckbox = document.getElementById(`jr_${index}`);
                const gearInput = document.getElementById(`gear_plan_id_${index}`);
                const wearInput = document.getElementById(`wear_plan_id_${index}`);
                const gloveInput = document.getElementById(`glove_plan_id_${index}`);
                const goggleInput = document.getElementById(`goggles_plan_id_${index}`);

                function toggleMenusByAge() {
                    const isChild = jrCheckbox.checked;

                    // メインギアメニューの切り替え
                    gearInput.querySelectorAll('.gear-adult').forEach(opt => {
                        opt.style.display = isChild ? 'none' : '';
                    });
                    gearInput.querySelectorAll('.gear-child').forEach(opt => {
                        opt.style.display = isChild ? '' : 'none';
                    });

                    // ウェアメニューの切り替え
                    wearInput.querySelectorAll('.wear-adult').forEach(opt => {
                        opt.style.display = isChild ? 'none' : '';
                    });
                    wearInput.querySelectorAll('.wear-child').forEach(opt => {
                        opt.style.display = isChild ? '' : 'none';
                    });

                    // グローブメニューの切り替え
                    gloveInput.querySelectorAll('.glove-adult').forEach(opt => {
                        opt.style.display = isChild ? 'none' : '';
                    });
                    gloveInput.querySelectorAll('.glove-child').forEach(opt => {
                        opt.style.display = isChild ? '' : 'none';
                    });

                    // ゴーグルメニューの切り替え
                    goggleInput.querySelectorAll('.goggle-adult').forEach(opt => {
                        opt.style.display = isChild ? 'none' : '';
                    });
                    goggleInput.querySelectorAll('.goggle-child').forEach(opt => {
                        opt.style.display = isChild ? '' : 'none';
                    });

                    // 選択値をリセット（該当カテゴリに存在しない場合）
                    if (gearInput.value) {
                        const selectedOption = gearInput.querySelector(`option[value="${gearInput.value}"]`);
                        if (selectedOption && selectedOption.style.display === 'none') {
                            gearInput.value = '';
                        }
                    }
                }

                jrCheckbox.addEventListener('change', toggleMenusByAge);
                toggleMenusByAge(); // 初期表示

                // ウェアプラン変更
                const wearSizeGroup = section.querySelector('.wear-size-group');
                wearInput.addEventListener("change", () => {
                    if (wearInput.value) {
                        wearSizeGroup.classList.remove('hidden');
                    } else {
                        wearSizeGroup.classList.add('hidden');
                    }
                });
                if (wearInput.value) {
                    wearSizeGroup.classList.remove('hidden');
                }

                // グローブプラン変更
                const gloveSizeGroup = section.querySelector('.glove-size-group');
                gloveInput.addEventListener("change", () => {
                    if (gloveInput.value) {
                        gloveSizeGroup.classList.remove('hidden');
                    } else {
                        gloveSizeGroup.classList.add('hidden');
                    }
                });
                if (gloveInput.value) {
                    gloveSizeGroup.classList.remove('hidden');
                }

                // ギアプラン変更（スタンスとStep On表示制御）
                const stanceGroup = section.querySelector('.stance-group');
                const stepOnGroup = section.querySelector('.step-on-group');
                const boardCategoryId = gearInput.dataset.categoryId;

                function updateGearRelatedFields() {
                    if (gearInput.value) {
                        const selectedOption = gearInput.querySelector(`option[value="${gearInput.value}"]`);
                        const selectedCategory = selectedOption ? selectedOption.dataset.category : null;

                        // スノーボードカテゴリの場合のみスタンスとStep Onを表示
                        if (selectedCategory == boardCategoryId) {
                            stanceGroup.classList.remove('hidden');
                            stepOnGroup.classList.remove('hidden');
                        } else if (gearInput.value) {
                            // スキーなど他のギアの場合はスタンスとStep Onを非表示
                            stanceGroup.classList.add('hidden');
                            stepOnGroup.classList.add('hidden');
                        }
                    } else {
                        stanceGroup.classList.add('hidden');
                        stepOnGroup.classList.add('hidden');
                    }
                }

                gearInput.addEventListener("change", updateGearRelatedFields);
                updateGearRelatedFields(); // 初期表示
            });

            function validateInput(inputElement, errorElement, errorMessage) {
                if (inputElement.value.trim() === "") {
                    errorElement.textContent = errorMessage;
                    return false;
                } else {
                    if (!errorElement.textContent.startsWith('※')) {
                        errorElement.textContent = "";
                    }
                    return true;
                }
            }

            function validateInputCheck(inputElement, errorElement, matchWord, errorMessage) {
                if (inputElement.value.trim() === matchWord) {
                    errorElement.textContent = errorMessage;
                    return false;
                } else {
                    if (!errorElement.textContent.startsWith('※')) {
                        errorElement.textContent = "";
                    }
                    return true;
                }
            }

            function validateForm() {
                let allValid = true;

                document.querySelectorAll('.guest-section').forEach((section) => {
                    const nameInput = section.querySelector('.name-input');
                    const furiganaInput = section.querySelector('.furigana-input');
                    const sexInput = section.querySelector('.sex-input');
                    const tallInput = section.querySelector('.tall-input');
                    const footInput = section.querySelector('.foot-input');

                    const nameError = section.querySelector('.name-error');
                    const furiganaError = section.querySelector('.furigana-error');
                    const sexError = section.querySelector('.sex-error');
                    const tallError = section.querySelector('.tall-error');
                    const footError = section.querySelector('.foot-error');

                    const isValid =
                        validateInput(nameInput, nameError, "入力してください。") &&
                        validateInput(furiganaInput, furiganaError, "入力してください。") &&
                        validateInputCheck(sexInput, sexError, "", "選択してください。") &&
                        validateInput(tallInput, tallError, "入力してください。") &&
                        validateInputCheck(footInput, footError, "", "選択してください。");

                    if (!isValid) {
                        allValid = false;
                    }
                });

                if (allValid) {
                    submitButton.classList.remove("disabled");
                    submitButton2.classList.remove("disabled");
                } else {
                    submitButton.classList.add("disabled");
                    submitButton2.classList.add("disabled");
                }
            }

            // 各入力要素にバリデーションを登録
            document.querySelectorAll('.name-input, .furigana-input, .tall-input').forEach(input => {
                input.addEventListener("blur", validateForm);
            });

            document.querySelectorAll('.sex-input, .foot-input').forEach(input => {
                input.addEventListener("change", validateForm);
            });

            validateForm();
        });
    </script>
</body>

</html>
