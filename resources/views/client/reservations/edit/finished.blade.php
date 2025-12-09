<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>変更完了 | RENTAL AAA</title>
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
            display: flex;
            flex-direction: column;
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

        .content-wrapper {
            padding: 4rem 2rem;
            text-align: center;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background: #dcfce7;
            color: #166534;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
        }

        .success-icon svg {
            width: 40px;
            height: 40px;
        }

        h2 {
            color: #1a1a1a;
            margin-bottom: 1.5rem;
            font-size: 1.8rem;
        }

        p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 3rem;
        }

        .btn-home {
            padding: 1rem 3rem;
            font-size: 1.1rem;
            font-weight: 600;
            color: #fff;
            background: #e63946;
            border: none;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s;
            display: inline-block;
        }

        .btn-home:hover {
            background: #d62839;
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(230, 57, 70, 0.4);
        }
    </style>
</head>

<body>
    <div class="main-container">
        <div class="logo-section">
            <img src="{{ asset('images/client/header-logo.png') }}" alt="ロゴ">
        </div>

        <div class="content-wrapper">
            <div class="success-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>

            <h2>変更が完了しました</h2>
            <p>
                ご予約内容の変更を受け付けました。<br>
                登録されたメールアドレスへ確認メールを送信しました。
            </p>

            <a href="{{ route('home') }}" class="btn-home">トップページへ戻る</a>
        </div>
    </div>
</body>

</html>
