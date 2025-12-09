<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>予約内容の変更 | RENTAL AAA</title>
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

        .button-container {
            display: flex;
            gap: 1rem;
            justify-content: center;
            padding: 2rem;
            border-top: 2px solid #e5e5e5;
            background: #ffffff;
            flex-direction: column;
            align-items: center;
        }

        /* メニュー独自スタイル */
        .edit-item {
            background: #ffffff;
            border: 1px solid #e5e5e5;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border-radius: 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.2s;
        }

        .edit-item:hover {
            border-color: #e63946;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .item-info h5 {
            font-size: 1rem;
            color: #2d2d2d;
            margin-bottom: 0.2rem;
        }

        .item-info p {
            font-size: 0.85rem;
            color: #666;
        }

        .btn-edit {
            background: #fff;
            border: 1px solid #2d2d2d;
            color: #2d2d2d;
            padding: 0.5rem 1rem;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .btn-edit:hover {
            background: #2d2d2d;
            color: #fff;
        }

        .btn-complete {
            padding: 1rem 3rem;
            font-size: 1.1rem;
            font-weight: 600;
            color: #fff;
            background: #e63946;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s;
        }

        .btn-complete:hover {
            background: #d62839;
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(230, 57, 70, 0.4);
        }

        .msg-success {
            background: #dcfce7;
            color: #166534;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 4px;
            font-size: 0.9rem;
            text-align: center;
        }

        @media (max-width: 768px) {
            .form-wrapper {
                padding: 1.5rem;
            }

            .edit-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .btn-edit {
                width: 100%;
                text-align: center;
            }

            .btn-complete {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <div class="main-container">
        <div class="logo-section">
            <img src="{{ asset('images/client/header-logo.png') }}" alt="ロゴ">
            <h4>予約内容の変更</h4>
        </div>

        <div class="form-wrapper">
            @if (session('status'))
                <div class="msg-success">
                    {{ session('status') }}
                </div>
            @endif

            <p style="margin-bottom: 1.5rem; font-weight: bold; color: #2d2d2d;">修正する項目を選択してください</p>

            <div class="edit-item">
                <div class="item-info">
                    <h5>代表者情報</h5>
                    <p>{{ $reservation->rep_full_name }} 様</p>
                </div>
                {{-- ★ここが edit.header になっているか確認 --}}
                <a href="{{ route('client.reservation.edit.header') }}" class="btn-edit">代表者情報を修正</a>
            </div>

            @foreach ($reservation->details as $detail)
                <div class="edit-item">
                    <div class="item-info">
                        <h5>利用者 {{ $loop->iteration }}</h5>
                        <p>{{ $detail->guest_name }} 様</p>
                    </div>
                    {{-- ★ここが edit.detail になっているか確認 --}}
                    <a href="{{ route('client.reservation.edit.detail', $detail->id) }}" class="btn-edit">情報を修正</a>
                </div>
            @endforeach
        </div>

        <div class="button-container">
            <p style="font-size: 0.85rem; color: #666; margin-bottom: 0.5rem;">すべての修正が完了したらボタンを押してください</p>
            <form method="POST" action="{{ route('client.reservation.edit.complete') }}"
                style="width: 100%; text-align: center;">
                @csrf
                <button type="submit" class="btn-complete">変更を完了する</button>
            </form>
        </div>
    </div>
</body>

</html>
