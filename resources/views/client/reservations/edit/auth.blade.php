<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>予約変更：本人確認 | RENTAL AAA</title>
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

        .error-msg {
            color: #e63946;
            font-size: 0.85rem;
            margin-top: 0.3rem;
            display: block;
            font-weight: 600;
            min-height: 1.2rem;
        }

        /* ★修正: 背景色をグレーに変更し、ボーダーを削除 */
        .button-container {
            display: flex;
            gap: 1rem;
            justify-content: center;
            padding: 2rem;
            background: #f5f5f5;
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
            color: #fff;
            background: #e63946;
        }

        .btn:hover {
            background: #d62839;
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(230, 57, 70, 0.4);
        }

        @media (max-width: 768px) {
            .form-wrapper {
                padding: 1.5rem;
            }

            .btn {
                width: 100%;
                padding: 0.8rem 2rem;
            }
        }
    </style>
</head>

<body>
    <div class="main-container">
        <div class="logo-section">
            <img src="{{ asset('images/client/header-logo.png') }}" alt="ロゴ">
            <h4>予約変更：本人確認</h4>
        </div>

        <div class="form-wrapper">
            <p style="margin-bottom: 1.5rem; color: #666; font-size: 0.9rem;">
                予約時の情報を入力して本人確認を行ってください。
            </p>

            @if ($errors->any())
                <div style="background: #fee2e2; border-left: 4px solid #ef4444; padding: 1rem; margin-bottom: 1.5rem;">
                    <p style="color: #b91c1c; font-weight: bold; font-size: 0.9rem;">
                        {{ $errors->first('auth_failed') ?: '入力内容を確認してください。' }}
                    </p>
                </div>
            @endif

            <form action="{{ route('client.reservation.edit.auth.verify') }}" method="post">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <label for="phone">電話番号</label>
                    <input id="phone" type="tel" class="form-control" name="phone" placeholder="09012345678"
                        required>
                </div>

                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input id="email" type="email" class="form-control" name="email"
                        placeholder="example@email.com" required>
                </div>

                <div class="form-group">
                    <label for="visit_date">利用日（ご来店日）</label>
                    <input id="visit_date" type="date" class="form-control" name="visit_date" required>
                </div>

        </div>
        {{-- button-containerをform-wrapperの外に出すか、背景色を変えて対応 --}}
        <div class="button-container">
            <button type="submit" class="btn">次へ</button>
        </div>
        </form>
    </div>
</body>

</html>
