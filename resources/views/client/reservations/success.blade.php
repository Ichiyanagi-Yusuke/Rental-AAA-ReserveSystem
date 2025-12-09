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
            padding: 2rem 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .main-container {
            max-width: 600px;
            width: 100%;
            background: #ffffff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
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

        .message-section {
            padding: 3rem 2rem;
            text-align: center;
        }

        .success-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 2rem;
            background: #28a745;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .success-icon::before {
            content: '';
            position: absolute;
            width: 12px;
            height: 25px;
            border-right: 4px solid #ffffff;
            border-bottom: 4px solid #ffffff;
            transform: rotate(45deg) translateY(-3px);
        }

        .success-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #28a745;
            margin-bottom: 1rem;
            letter-spacing: 0.05em;
        }

        .success-message {
            font-size: 1.1rem;
            color: #2d2d2d;
            line-height: 1.8;
            margin-bottom: 1.5rem;
        }

        .notice-box {
            background: #f8f9fa;
            padding: 1.5rem;
            border-left: 4px solid #e63946;
            margin: 2rem 0;
            text-align: left;
        }

        .notice-title {
            font-size: 0.9rem;
            font-weight: 700;
            color: #e63946;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .notice-text {
            font-size: 0.95rem;
            color: #2d2d2d;
            line-height: 1.7;
        }

        .button-container {
            padding: 2rem;
            border-top: 2px solid #e5e5e5;
            text-align: center;
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
            min-width: 180px;
            cursor: pointer;
            background: #ffffff;
            color: #1a1a1a;
            border: 2px solid #2d2d2d;
        }

        .btn:hover {
            background: #2d2d2d;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem 0.5rem;
            }

            .logo-section h4 {
                font-size: 1.5rem;
            }

            .message-section {
                padding: 2rem 1.5rem;
            }

            .success-title {
                font-size: 1.5rem;
            }

            .success-icon {
                width: 60px;
                height: 60px;
            }

            .success-icon::before {
                width: 10px;
                height: 20px;
                border-right: 3px solid #ffffff;
                border-bottom: 3px solid #ffffff;
            }

            .success-message {
                font-size: 1rem;
            }

            .notice-box {
                padding: 1rem;
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

        <div class="message-section">
            <div class="success-icon"></div>
            <h1 class="success-title">ご予約完了</h1>
            <p class="success-message">
                ご予約を承りました。<br>
                完了メールをご確認ください。
            </p>

            <div class="notice-box">
                <p class="notice-title">※ ご注意</p>
                <p class="notice-text">
                    迷惑メールに振り分けられている可能性があります。<br>
                    届いていない場合は迷惑メールフォルダの確認もお願いいたします。
                </p>
            </div>
        </div>

        <div class="button-container">
            <a href="https://rental-aaa.jp" class="btn">TOPへ戻る</a>
        </div>
    </div>
</body>

</html>
