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
            max-width: 900px;
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

        .content-wrapper {
            padding: 2.5rem;
        }

        .notice-section {
            background: #2d2d2d;
            color: #ffffff;
            padding: 2rem 2.5rem;
            margin-bottom: 3rem;
            border-left: 5px solid #e63946;
        }

        .notice-title {
            font-weight: 700;
            font-size: 1.3rem;
            text-align: center;
            margin-bottom: 1rem;
        }

        .notice-text {
            color: #ffffff;
            font-size: 1.1rem;
            line-height: 1.8;
        }

        .highlight-date {
            color: #e63946;
            font-weight: bold;
            padding: 0.2rem 0.5rem;
            background: rgba(230, 57, 70, 0.15);
        }

        .section-title {
            color: #1a1a1a;
            font-weight: 700;
            font-size: 1.8rem;
            text-align: center;
            margin: 2rem 0;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e5e5e5;
            position: relative;
        }

        .section-title::before {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 2px;
            background: #e63946;
        }

        .terms-list {
            background: #fafafa;
            padding: 2.5rem;
            margin-bottom: 3rem;
        }

        .terms-item {
            color: #2d2d2d;
            font-size: 1rem;
            line-height: 1.9;
            margin-bottom: 1.5rem;
            padding-left: 1rem;
            border-left: 3px solid #e63946;
            transition: all 0.3s ease;
        }

        .terms-item:last-child {
            margin-bottom: 0;
        }

        .terms-item:hover {
            background: #ffffff;
            padding-left: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .checkbox-section {
            background: #fafafa;
            padding: 2.5rem;
            margin-bottom: 3rem;
            text-align: center;
        }

        .checkbox-wrapper {
            display: inline-flex;
            align-items: center;
            cursor: pointer;
        }

        .checkbox-wrapper input[type="checkbox"] {
            width: 24px;
            height: 24px;
            margin-right: 1rem;
            cursor: pointer;
            accent-color: #e63946;
        }

        .checkbox-wrapper label {
            color: #1a1a1a;
            font-weight: 600;
            font-size: 1.3rem;
            cursor: pointer;
            margin: 0;
        }

        .button-container {
            display: flex;
            gap: 1rem;
            justify-content: center;
            padding: 2rem;
            border-top: 2px solid #e5e5e5;
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
            .logo-section h4 {
                font-size: 1.5rem;
            }

            .content-wrapper {
                padding: 1.5rem;
            }

            .section-title {
                font-size: 1.4rem;
            }

            .notice-section {
                padding: 1.5rem;
            }

            .notice-text {
                font-size: 1rem;
            }

            .terms-list {
                padding: 1.5rem;
            }

            .terms-item {
                font-size: 0.95rem;
            }

            .checkbox-wrapper label {
                font-size: 1.1rem;
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
            <h4>WEB予約</h4>
        </div>

        <div class="content-wrapper">
            <div class="notice-section">
                <p class="notice-title">お知らせ</p>
                <p class="notice-text">
                    2025-2026シーズンの営業開始日は<span class="highlight-date">2025/12/13</span>です。何卒ご了承くださいませ。
                </p>
            </div>

            <h2 class="section-title">同意事項</h2>

            <div class="terms-list">
                <p class="terms-item">１）レンタル品使用中での怪我、事故の補償等は自己責任となり当店からの補償は一切ございません。</p>
                <p class="terms-item">２）道路事情等により返却が遅れる場合は、延長料金はいただきません。遅れる旨の連絡だけ店舗へご連絡ください。</p>
                <p class="terms-item">３）レンタル品の盗難、紛失、不注意等によるレンタル品の損害に関しては、相当額の費用をお支払いいただきます。</p>
                <p class="terms-item">４）10名以上のご予約の際は、店舗営業時間に直接お電話でご連絡ください。</p>
                <p class="terms-item">５）当日キャンセルの場合は店舗へご連絡ください。</p>
                <p class="terms-item">６）ナイター利用は貸出時刻により料金が変動するため、来店後ご相談いただく形になります。</p>
                <p class="terms-item">７）貸出時にご予約の代表者様のみ身分証明証の確認をいたします。ご準備の上ご来店ください。</p>
            </div>

            <div class="checkbox-section">
                <form action="{{ route('client.reservation.agree.store') }}" method="post" id="mainform"
                    name="mainform">
                    @csrf
                    <div class="checkbox-wrapper">
                        <input type="hidden" name="agree" value="0" />
                        <input type="checkbox" name="agree" value="1" id="agree" />
                        <label for="agree">同意する</label>
                    </div>
                </form>
            </div>
        </div>

        <div class="button-container">
            <a href="https://rental-aaa.jp" class="btn btn-back">戻る</a>
            <a href="#" onclick="document.mainform.submit(); return false;" id="submit-tag"
                class="btn btn-submit disabled">次へ</a>
        </div>
    </div>

    <script>
        document.documentElement.classList.remove('dark');

        document.addEventListener("DOMContentLoaded", () => {
            const form = document.getElementById("mainform");
            const agreeCheckbox = document.getElementById("agree");
            const submitButton = document.getElementById("submit-tag");

            function validateForm() {
                if (agreeCheckbox.checked) {
                    submitButton.classList.remove("disabled");
                } else {
                    submitButton.classList.add("disabled");
                }
            }

            agreeCheckbox.addEventListener("change", validateForm);
            validateForm();
        });
    </script>
</body>

</html>
