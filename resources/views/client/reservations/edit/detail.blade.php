<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>利用者情報の編集 | RENTAL AAA</title>
    <style>
        /* 共通スタイル */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
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
            font-size: 1.5rem;
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

        .hidden {
            display: none !important;
        }

        .error-msg {
            color: #e63946;
            font-size: 0.85rem;
            margin-top: 0.3rem;
            display: block;
            font-weight: 600;
        }

        .button-container {
            display: flex;
            gap: 1rem;
            justify-content: center;
            padding: 2rem;
            border-top: 2px solid #e5e5e5;
            background: #ffffff;
        }

        .btn {
            padding: 1rem 3rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 140px;
            border: none;
            transition: all 0.3s;
        }

        .btn-submit {
            background: #e63946;
            color: #ffffff;
        }

        .btn-submit:hover {
            background: #d62839;
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(230, 57, 70, 0.4);
        }

        .btn-back {
            background: #ffffff;
            color: #1a1a1a;
            border: 2px solid #2d2d2d;
        }

        .btn-back:hover {
            background: #2d2d2d;
            color: #ffffff;
        }

        @media (max-width: 768px) {
            .form-wrapper {
                padding: 1.5rem;
            }

            .button-container {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="main-container">
        <div class="logo-section">
            <img src="{{ asset('images/client/header-logo.png') }}" alt="ロゴ">
            <h4>利用者情報の編集</h4>
        </div>

        <div class="form-wrapper">
            <h5
                style="margin-bottom: 1.5rem; border-bottom: 1px solid #ccc; padding-bottom: 0.5rem; font-weight: bold;">
                {{ $detail->guest_name }} 様
            </h5>

            <form action="{{ route('client.reservation.edit.detail.update', $detail->id) }}" method="post"
                id="detailForm">
                @csrf

                <div class="checkbox-group">
                    <div class="checkbox-wrapper">
                        <input type="checkbox" name="is_child" value="1" id="is_child"
                            {{ old('is_child', $detail->is_child) ? 'checked' : '' }}>
                        <label for="is_child">中学生以下 (Junior)</label>
                    </div>
                </div>

                <div class="form-group">
                    <label>利用者名</label>
                    <input type="text" class="form-control" name="guest_name"
                        value="{{ old('guest_name', $detail->guest_name) }}" required>
                    @error('guest_name')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>フリガナ</label>
                    <input type="text" class="form-control" name="guest_name_kana"
                        value="{{ old('guest_name_kana', $detail->guest_name_kana) }}" required>
                    @error('guest_name_kana')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>性別</label>
                    <select class="form-control" name="gender">
                        <option value="">性別を選択</option>
                        <option value="0" {{ old('gender', $detail->gender) === '0' ? 'selected' : '' }}>女性
                        </option>
                        <option value="1" {{ old('gender', $detail->gender) === '1' ? 'selected' : '' }}>男性
                        </option>
                        <option value="2" {{ old('gender', $detail->gender) === '2' ? 'selected' : '' }}>回答しない
                        </option>
                    </select>
                    @error('gender')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>身長 (cm)</label>
                    <input type="number" class="form-control" name="height"
                        value="{{ old('height', $detail->height) }}">
                    @error('height')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>足の大きさ (cm)</label>
                    <select class="form-control" name="foot_size">
                        <option value="">足の大きさ</option>
                        @for ($i = 15.5; $i < 32.0; $i = $i + 0.5)
                            <option value="{{ $i }}"
                                {{ (string) old('foot_size', $detail->foot_size) === (string) $i ? 'selected' : '' }}>
                                {{ $i }} cm
                            </option>
                        @endfor
                    </select>
                    @error('foot_size')
                        <span class="error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>メインギア</label>
                    <select class="form-control" name="main_gear_menu_id" id="main_gear_menu_id"
                        data-board-category="{{ $boardCategoryId }}">
                        <option value="">利用しない</option>
                        @foreach ($gear_plans_adult as $menu)
                            <option value="{{ $menu->id }}" class="gear-adult"
                                data-category="{{ $menu->rental_menu_category_id }}"
                                {{ old('main_gear_menu_id', $detail->main_gear_menu_id) == $menu->id ? 'selected' : '' }}>
                                {{ $menu->name }}
                            </option>
                        @endforeach
                        @foreach ($gear_plans_child as $menu)
                            <option value="{{ $menu->id }}" class="gear-child hidden"
                                data-category="{{ $menu->rental_menu_category_id }}"
                                {{ old('main_gear_menu_id', $detail->main_gear_menu_id) == $menu->id ? 'selected' : '' }}>
                                {{ $menu->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group stance-group hidden">
                    <label>スタンス</label>
                    <select class="form-control" name="stance">
                        <option value="">選択して下さい</option>
                        <option value="レギュラー" {{ old('stance', $detail->stance) == 'レギュラー' ? 'selected' : '' }}>レギュラー
                        </option>
                        <option value="グーフィー" {{ old('stance', $detail->stance) == 'グーフィー' ? 'selected' : '' }}>グーフィー
                        </option>
                    </select>
                </div>

                <div class="checkbox-group step-on-group hidden">
                    <div class="checkbox-wrapper">
                        <input type="checkbox" name="is_step_on" value="1" id="is_step_on"
                            {{ old('is_step_on', $detail->is_step_on) ? 'checked' : '' }}>
                        <label for="is_step_on">Step On利用</label>
                    </div>
                </div>

                <div class="form-group">
                    <label>レンタルウェア</label>
                    <select class="form-control" name="wear_menu_id" id="wear_menu_id">
                        <option value="">利用しない</option>
                        @foreach ($wear_plans_adult as $menu)
                            <option value="{{ $menu->id }}" class="wear-adult"
                                {{ old('wear_menu_id', $detail->wear_menu_id) == $menu->id ? 'selected' : '' }}>
                                {{ $menu->name }}
                            </option>
                        @endforeach
                        @foreach ($wear_plans_child as $menu)
                            <option value="{{ $menu->id }}" class="wear-child hidden"
                                {{ old('wear_menu_id', $detail->wear_menu_id) == $menu->id ? 'selected' : '' }}>
                                {{ $menu->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group wear-size-group hidden">
                    <label>ウェアサイズ</label>
                    <select class="form-control" name="wear_size">
                        <option value="">サイズ選択</option>
                        @foreach (['100', '110', '120', '130', '140', '150', 'S', 'M', 'L', 'XL', 'XXL'] as $size)
                            <option value="{{ $size }}"
                                {{ old('wear_size', $detail->wear_size) == $size ? 'selected' : '' }}>
                                {{ $size }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>レンタルグローブ</label>
                    <select class="form-control" name="glove_menu_id" id="glove_menu_id">
                        <option value="">利用しない</option>
                        @foreach ($glove_plans_adult as $menu)
                            <option value="{{ $menu->id }}" class="glove-adult"
                                {{ old('glove_menu_id', $detail->glove_menu_id) == $menu->id ? 'selected' : '' }}>
                                {{ $menu->name }}
                            </option>
                        @endforeach
                        @foreach ($glove_plans_child as $menu)
                            <option value="{{ $menu->id }}" class="glove-child hidden"
                                {{ old('glove_menu_id', $detail->glove_menu_id) == $menu->id ? 'selected' : '' }}>
                                {{ $menu->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group glove-size-group hidden">
                    <label>グローブサイズ</label>
                    <select class="form-control" name="glove_size">
                        <option value="">サイズ選択</option>
                        <option value="S" {{ old('glove_size', $detail->glove_size) == 'S' ? 'selected' : '' }}>S
                        </option>
                        <option value="M" {{ old('glove_size', $detail->glove_size) == 'M' ? 'selected' : '' }}>M
                        </option>
                        <option value="L" {{ old('glove_size', $detail->glove_size) == 'L' ? 'selected' : '' }}>L
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label>レンタルゴーグル</label>
                    <select class="form-control" name="goggle_menu_id" id="goggle_menu_id">
                        <option value="">利用しない</option>
                        @foreach ($goggles_plans_adult as $menu)
                            <option value="{{ $menu->id }}" class="goggle-adult"
                                {{ old('goggle_menu_id', $detail->goggle_menu_id) == $menu->id ? 'selected' : '' }}>
                                {{ $menu->name }}
                            </option>
                        @endforeach
                        @foreach ($goggles_plans_child as $menu)
                            <option value="{{ $menu->id }}" class="goggle-child hidden"
                                {{ old('goggle_menu_id', $detail->goggle_menu_id) == $menu->id ? 'selected' : '' }}>
                                {{ $menu->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="checkbox-group">
                    <div class="checkbox-wrapper">
                        <input type="checkbox" name="is_helmet_used" value="1" id="is_helmet_used"
                            {{ old('is_helmet_used', $detail->is_helmet_used) ? 'checked' : '' }}>
                        <label for="is_helmet_used">ヘルメット</label>
                    </div>
                </div>

                <div class="form-group">
                    <label>個別のご要望</label>
                    <textarea class="form-control" name="note" placeholder="個別のご要望があればご記入ください">{{ old('note', $detail->note) }}</textarea>
                </div>

                <div class="button-container">
                    <a href="{{ route('client.reservation.edit.menu') }}" class="btn btn-back">戻る</a>
                    <button type="submit" class="btn btn-submit">保存して戻る</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const jrCheckbox = document.getElementById('is_child');
            const gearInput = document.getElementById('main_gear_menu_id');
            const wearInput = document.getElementById('wear_menu_id');
            const gloveInput = document.getElementById('glove_menu_id');
            const goggleInput = document.getElementById('goggle_menu_id');
            const boardCategoryId = gearInput.dataset.boardCategory;

            // 1. 子供・大人 メニュー切り替え
            function toggleMenusByAge() {
                const isChild = jrCheckbox.checked;

                // 各select内のoptionの表示制御
                toggleOptions(gearInput, '.gear-adult', '.gear-child', isChild);
                toggleOptions(wearInput, '.wear-adult', '.wear-child', isChild);
                toggleOptions(gloveInput, '.glove-adult', '.glove-child', isChild);
                toggleOptions(goggleInput, '.goggle-adult', '.goggle-child', isChild);

                // 選択中メニューが非表示になった場合のリセット
                resetSelectionIfHidden(gearInput);
                resetSelectionIfHidden(wearInput);
                resetSelectionIfHidden(gloveInput);
                resetSelectionIfHidden(goggleInput);

                // 依存項目の更新
                updateGearRelatedFields();
            }

            function toggleOptions(select, adultClass, childClass, isChild) {
                select.querySelectorAll(adultClass).forEach(opt => {
                    opt.style.display = isChild ? 'none' : '';
                    if (isChild) opt.classList.add('hidden');
                    else opt.classList.remove('hidden');
                });
                select.querySelectorAll(childClass).forEach(opt => {
                    opt.style.display = isChild ? '' : 'none';
                    if (!isChild) opt.classList.add('hidden');
                    else opt.classList.remove('hidden');
                });
            }

            function resetSelectionIfHidden(select) {
                if (select.value) {
                    const selectedOption = select.querySelector(`option[value="${select.value}"]`);
                    if (selectedOption && (selectedOption.style.display === 'none' || selectedOption.classList
                            .contains('hidden'))) {
                        select.value = '';
                        select.dispatchEvent(new Event('change')); // changeイベント発火
                    }
                }
            }

            jrCheckbox.addEventListener('change', toggleMenusByAge);

            // 2. ウェア・グローブ サイズ表示制御
            const wearSizeGroup = document.querySelector('.wear-size-group');
            wearInput.addEventListener("change", () => {
                wearSizeGroup.classList.toggle('hidden', !wearInput.value);
            });

            const gloveSizeGroup = document.querySelector('.glove-size-group');
            gloveInput.addEventListener("change", () => {
                gloveSizeGroup.classList.toggle('hidden', !gloveInput.value);
            });

            // 3. ギア連動（スタンス・StepOn）
            const stanceGroup = document.querySelector('.stance-group');
            const stepOnGroup = document.querySelector('.step-on-group');

            function updateGearRelatedFields() {
                if (gearInput.value) {
                    const selectedOption = gearInput.querySelector(`option[value="${gearInput.value}"]`);
                    const selectedCategory = selectedOption ? selectedOption.dataset.category : null;

                    if (selectedCategory == boardCategoryId) {
                        stanceGroup.classList.remove('hidden');
                        stepOnGroup.classList.remove('hidden');
                    } else {
                        stanceGroup.classList.add('hidden');
                        stepOnGroup.classList.add('hidden');
                    }
                } else {
                    stanceGroup.classList.add('hidden');
                    stepOnGroup.classList.add('hidden');
                }
            }

            gearInput.addEventListener("change", updateGearRelatedFields);

            // 初期実行
            toggleMenusByAge();
            if (wearInput.value) wearSizeGroup.classList.remove('hidden');
            if (gloveInput.value) gloveSizeGroup.classList.remove('hidden');
            updateGearRelatedFields();
        });
    </script>
</body>

</html>
