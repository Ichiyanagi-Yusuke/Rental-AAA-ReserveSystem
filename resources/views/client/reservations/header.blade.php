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

        input[type="date"].form-control,
        input[type="time"].form-control {
            cursor: pointer;
        }

        .error-msg {
            color: #e63946;
            font-size: 0.85rem;
            margin-top: 0.3rem;
            display: block;
            font-weight: 600;
            min-height: 1.2rem;
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
            font-size: 1.1rem;
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
                padding: 0.8rem 2rem;
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="main-container">
        <div class="logo-section">
            <img src="{{ asset('images/client/header-logo.png') }}" alt="ロゴ">
            <h4>代表者情報</h4>
        </div>

        <div class="form-wrapper">
            <form action="{{ route('client.reservation.header.store') }}" method="post" id="mainform" name="mainform">
                @csrf

                <div class="form-group">
                    <label for="last_name">姓</label>
                    <input id="last_name" type="text" class="form-control" placeholder="山田" maxlength="20"
                        name="last_name" value="{{ old('last_name', $header['last_name'] ?? '') }}">
                    <span id="last_name_error" class="error-msg">
                        @error('last_name')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="form-group">
                    <label for="last_name_f">セイ</label>
                    <input id="last_name_f" type="text" class="form-control" placeholder="ヤマダ" maxlength="20"
                        name="last_name_f" value="{{ old('last_name_f', $header['last_name_f'] ?? '') }}">
                    <span id="last_name_f_error" class="error-msg">
                        @error('last_name_f')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="form-group">
                    <label for="first_name">名</label>
                    <input id="first_name" type="text" class="form-control" placeholder="太郎" maxlength="20"
                        name="first_name" value="{{ old('first_name', $header['first_name'] ?? '') }}">
                    <span id="first_name_error" class="error-msg">
                        @error('first_name')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="form-group">
                    <label for="first_name_f">メイ</label>
                    <input id="first_name_f" type="text" class="form-control" placeholder="タロウ" maxlength="20"
                        name="first_name_f" value="{{ old('first_name_f', $header['first_name_f'] ?? '') }}">
                    <span id="first_name_f_error" class="error-msg">
                        @error('first_name_f')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="form-group">
                    <label for="tel">携帯電話番号</label>
                    <input id="tel" type="tel" class="form-control" placeholder="09012345678" maxlength="20"
                        name="tel" value="{{ old('tel', $header['tel'] ?? '') }}">
                    <span id="tel_error" class="error-msg">
                        @error('tel')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input id="email" type="text" class="form-control" placeholder="example@email.com"
                        maxlength="255" name="email" value="{{ old('email', $header['email'] ?? '') }}">
                    <span id="email_error" class="error-msg">
                        @error('email')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="form-group">
                    <label for="reserve_date">来店予定日</label>
                    <input id="reserve_date" type="date" class="form-control" name="reserve_date" min="2025-12-13"
                        max="2026-04-30" value="{{ old('reserve_date', $header['reserve_date'] ?? '') }}">
                    <span id="reserve_date_error" class="error-msg">
                        @error('reserve_date')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="form-group">
                    <label for="reserve_time">来店予定時刻</label>
                    <input id="reserve_time" type="time" class="form-control" name="reserve_time"
                        value="{{ old('reserve_time', $header['reserve_time'] ?? '') }}">
                    <span id="reserve_time_error" class="error-msg">
                        @error('reserve_time')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="form-group">
                    <label for="return_date">返却予定日</label>
                    <input id="return_date" type="date" class="form-control" name="return_date" min="2025-12-13"
                        max="2026-04-30" value="{{ old('return_date', $header['return_date'] ?? '') }}">
                    <span id="return_date_error" class="error-msg">
                        @error('return_date')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="form-group">
                    <label for="resort">ゲレンデ選択</label>
                    <select class="form-control" id="resort" name="resort_id">
                        <option value="">選択してください</option>
                        @foreach ($resorts as $resort)
                            <option value="{{ $resort->id }}"
                                {{ old('resort_id', $header['resort_id'] ?? '') == $resort->id ? 'selected' : '' }}>
                                {{ $resort->name }}
                            </option>
                        @endforeach
                    </select>
                    <span id="resort_error" class="error-msg">
                        @error('resort_id')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="form-group">
                    <label for="comment">その他ご要望</label>
                    <textarea id="comment" class="form-control" name="comment" placeholder="ご要望があればご記入ください">{{ old('comment', $header['comment'] ?? '') }}</textarea>
                </div>
            </form>
        </div>

        <div class="button-container">
            <a href="{{ route('client.reservation.agree') }}" class="btn btn-back">戻る</a>
            <a href="#" onclick="document.mainform.submit(); return false;" id="submit-tag"
                class="btn btn-submit disabled">次へ</a>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const form = document.getElementById("mainform");
            const submitButton = document.getElementById("submit-tag");

            // 入力要素の取得
            const last_name_Input = document.getElementById("last_name");
            const last_name_f_Input = document.getElementById("last_name_f");
            const first_name_Input = document.getElementById("first_name");
            const first_name_f_Input = document.getElementById("first_name_f");
            const tel_Input = document.getElementById("tel");
            const email_Input = document.getElementById("email");
            const reserve_date_Input = document.getElementById("reserve_date");
            const return_date_Input = document.getElementById("return_date");
            const reserve_time_Input = document.getElementById("reserve_time");
            const resort_Input = document.getElementById("resort");

            // エラー要素の取得
            const last_nameError = document.getElementById("last_name_error");
            const last_name_fError = document.getElementById("last_name_f_error");
            const first_nameError = document.getElementById("first_name_error");
            const first_name_fError = document.getElementById("first_name_f_error");
            const telError = document.getElementById("tel_error");
            const emailError = document.getElementById("email_error");
            const reserve_dateError = document.getElementById("reserve_date_error");
            const return_dateError = document.getElementById("return_date_error");
            const reserve_timeError = document.getElementById("reserve_time_error");
            const resortError = document.getElementById("resort_error");

            function validateInput(inputElement, errorElement, errorMessage) {
                if (inputElement.value.trim() == "") {
                    errorElement.textContent = errorMessage;
                    return false;
                } else {
                    if (!errorElement.textContent.startsWith('※') && !errorElement.textContent.includes('は')) {
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
                    if (!errorElement.textContent.startsWith('※') && !errorElement.textContent.includes('は')) {
                        errorElement.textContent = "";
                    }
                    return true;
                }
            }

            function validateForm() {
                const isValid =
                    validateInput(last_name_Input, last_nameError, "入力してください。") &&
                    validateInput(last_name_f_Input, last_name_fError, "入力してください。") &&
                    validateInput(first_name_Input, first_nameError, "入力してください。") &&
                    validateInput(first_name_f_Input, first_name_fError, "入力してください。") &&
                    validateInput(tel_Input, telError, "入力してください。") &&
                    validateInput(email_Input, emailError, "入力してください。") &&
                    validateInput(reserve_date_Input, reserve_dateError, "選択してください。") &&
                    validateInput(return_date_Input, return_dateError, "選択してください。") &&
                    validateInput(reserve_time_Input, reserve_timeError, "選択してください。") &&
                    validateInputCheck(resort_Input, resortError, "", "選択してください。");

                if (isValid) {
                    submitButton.classList.remove("disabled");
                } else {
                    submitButton.classList.add("disabled");
                }
            }

            // 各入力要素にバリデーションを登録
            last_name_Input.addEventListener("blur", validateForm);
            last_name_f_Input.addEventListener("blur", validateForm);
            first_name_Input.addEventListener("blur", validateForm);
            first_name_f_Input.addEventListener("blur", validateForm);
            tel_Input.addEventListener("blur", validateForm);
            email_Input.addEventListener("blur", validateForm);
            reserve_date_Input.addEventListener("change", validateForm);
            return_date_Input.addEventListener("change", validateForm);
            reserve_time_Input.addEventListener("change", validateForm);
            resort_Input.addEventListener("change", validateForm);

            const reserveDateInput = document.getElementById('reserve_date');
            const errorMsg = document.getElementById('reserve_date_error');
            const minDate = "2025-12-13";

            function validateDate() {
                const inputVal = reserveDateInput.value;

                if (!inputVal) {
                    return;
                }

                if (inputVal < minDate) {
                    errorMsg.textContent = "来店予定日は2025年12月13日以降を指定してください。";
                    errorMsg.style.color = "red";
                }
            }

            reserveDateInput.addEventListener('change', () => {
                validateDate();
                validateForm();
            });

            validateForm();
        });
    </script>
</body>

</html>
