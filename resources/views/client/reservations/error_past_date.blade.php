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

        .error-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 2rem;
            background: #e63946;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .error-icon::before {
            content: '×';
            color: #ffffff;
            font-size: 4rem;
            font-weight: 300;
            line-height: 1;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .error-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #e63946;
            margin-bottom: 1rem;
            letter-spacing: 0.05em;
        }

        .error-message {
            font-size: 1.1rem;
            color: #2d2d2d;
            line-height: 1.8;
            margin-bottom: 1.5rem;
        }

        .notice-box {
            background: #fff3cd;
            padding: 1.5rem;
            border-left: 4px solid #ffc107;
            margin: 2rem 0;
            text-align: left;
        }

        .notice-title {
            font-size: 0.9rem;
            font-weight: 700;
            color: #856404;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .notice-text {
            font-size: 0.95rem;
            color: #856404;
            line-height: 1.7;
        }

        .button-container {
            padding: 2rem;
            border-top: 2px solid #e5e5e5;
            text-align: center;
            display: flex;
            gap: 1rem;
            justify-content: center;
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

        .btn-retry {
            background: #e63946;
            color: #ffffff;
        }

        .btn-retry:hover {
            background: #d62839;
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(230, 57, 70, 0.4);
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

            .error-title {
                font-size: 1.5rem;
            }

            .error-icon {
                width: 60px;
                height: 60px;
            }

            .error-icon::before {
                font-size: 3rem;
            }

            .error-message {
                font-size: 1rem;
            }

            .notice-box {
                padding: 1rem;
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

        <div class="message-section">
            <div class="error-icon"></div>
            <h1 class="error-title">更新できません</h1>
            <p class="error-message">
                ご指定のご予約は既に利用日を超過しています。<br>
            </p>

        </div>

        <div class="button-container">
            <a href="https://rental-aaa.jp" class="btn btn-back">TOPへ戻る</a>
            <a href="{{ route('client.reservation.agree') }}" class="btn btn-retry">もう一度予約する</a>
        </div>
    </div>
</body>

</html>
