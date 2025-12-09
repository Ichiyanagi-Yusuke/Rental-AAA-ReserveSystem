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

        .content-wrapper {
            background: #fafafa;
            padding: 2.5rem;
        }

        .info-section {
            margin-bottom: 2rem;
            position: relative;
        }

        .info-section .edit-btn {
            position: absolute;
            top: 0;
            right: 0;
            padding: 0.5rem 1rem;
            background: #e63946;
            color: #ffffff;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .info-section .edit-btn:hover {
            background: #d62839;
            transform: translateY(-2px);
        }

        .info-item {
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e5e5e5;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .reserve-item-title {
            display: block;
            font-size: 0.85rem;
            color: #666666;
            font-weight: 600;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .reserve-item-content {
            font-size: 1.1rem;
            color: #1a1a1a;
            font-weight: 500;
        }

        .accordion {
            margin-top: 2rem;
        }

        .accordion-header {
            background: linear-gradient(135deg, #2d2d2d 0%, #1a1a1a 100%);
            color: #ffffff;
            padding: 1rem;
            font-weight: 700;
            font-size: 1.1rem;
            text-align: center;
            border-left: 5px solid #e63946;
            margin-bottom: 0.5rem;
        }

        .accordion input[type="radio"] {
            display: none;
        }

        .accordion-item {
            margin-bottom: 0.5rem;
            background: #ffffff;
            border-left: 3px solid #e63946;
        }

        .accordion-title {
            display: flex;
            align-items: center;
            padding: 1rem;
            background: #ffffff;
            color: #1a1a1a;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .accordion-title::after {
            content: '▼';
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            transition: transform 0.3s ease;
            font-size: 0.8rem;
        }

        .edit-guest-btn {
            padding: 0.4rem 0.8rem;
            background: #e63946;
            color: #ffffff;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            border-radius: 4px;
            transition: all 0.3s ease;
            margin-right: 2rem;
            z-index: 10;
        }

        .edit-guest-btn:hover {
            background: #d62839;
            transform: translateY(-2px);
            box-shadow: 0 2px 8px rgba(230, 57, 70, 0.3);
        }

        .accordion-title:hover {
            background: #f8f9fa;
        }

        .accordion-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            background: #f8f9fa;
        }

        .accordion-content-inner {
            padding: 1rem;
        }

        .accordion input[type="radio"]:checked+.accordion-item .accordion-title::after {
            transform: translateY(-50%) rotate(180deg);
        }

        .accordion input[type="radio"]:checked+.accordion-item .accordion-content {
            max-height: 2000px;
        }

        .item-row {
            padding: 0.75rem 0;
            border-bottom: 1px solid #e5e5e5;
        }

        .item-row:last-child {
            border-bottom: none;
        }

        .item-title {
            display: block;
            font-size: 0.85rem;
            color: #666666;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .item-content {
            font-size: 1rem;
            color: #1a1a1a;
            font-weight: 500;
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

        .btn-submit:hover {
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

            .content-wrapper {
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
            <h4>予約内容確認</h4>
        </div>

        <div class="content-wrapper">
            <form action="{{ route('client.reservation.store') }}" method="post" id="mainform" name="mainform">
                @csrf

                <div class="info-section">
                    <a href="{{ route('client.reservation.header') }}" class="edit-btn">修正</a>

                    <div class="info-item">
                        <span class="reserve-item-title">代表者名</span>
                        <p class="reserve-item-content">{{ $header['last_name'] }} {{ $header['first_name'] }} 様</p>
                    </div>

                    <div class="info-item">
                        <span class="reserve-item-title">フリガナ</span>
                        <p class="reserve-item-content">{{ $header['last_name_f'] }} {{ $header['first_name_f'] }} 様</p>
                    </div>

                    <div class="info-item">
                        <span class="reserve-item-title">電話番号</span>
                        <p class="reserve-item-content">{{ $header['tel'] }}</p>
                    </div>

                    <div class="info-item">
                        <span class="reserve-item-title">メールアドレス</span>
                        <p class="reserve-item-content">{{ $header['email'] }}</p>
                    </div>

                    <div class="info-item">
                        <span class="reserve-item-title">来店予定日時</span>
                        <p class="reserve-item-content">{{ $header['reserve_date'] }} {{ $header['reserve_time'] }}
                        </p>
                    </div>

                    <div class="info-item">
                        <span class="reserve-item-title">返却予定日</span>
                        <p class="reserve-item-content">{{ $header['return_date'] }}</p>
                    </div>

                    <div class="info-item">
                        <span class="reserve-item-title">ご利用のゲレンデ</span>
                        <p class="reserve-item-content">{{ $resort->name ?? '' }}</p>
                    </div>

                    <div class="info-item">
                        <span class="reserve-item-title">ご要望</span>
                        <p class="reserve-item-content">
                            @if (empty($header['comment']))
                                特になし
                            @else
                                {{ $header['comment'] }}
                            @endif
                        </p>
                    </div>
                </div>

                <div class="accordion">
                    <div class="accordion-header">
                        利用者情報
                    </div>

                    @foreach ($details as $index => $detail)
                        <input type="radio" name="accordion" id="acc-{{ $index + 1 }}" />
                        <div class="accordion-item">
                            <label class="accordion-title" for="acc-{{ $index + 1 }}">
                                <span style="flex: 1;">
                                    {{ $index + 1 }}. {{ $detail['name'] }} 様
                                    @if ($detail['jr'])
                                        （Jr）
                                    @endif
                                </span>
                                <a href="{{ route('client.reservation.edit.detail', ['index' => $index]) }}"
                                    class="edit-guest-btn"
                                    onclick="event.stopPropagation();">
                                    修正
                                </a>
                            </label>
                            <div class="accordion-content">
                                <div class="accordion-content-inner">
                                    <div class="item-row">
                                        <span class="item-title">性別</span>
                                        <p class="item-content">
                                            @switch($detail['sex'])
                                                @case('0')
                                                    女性
                                                @break

                                                @case('1')
                                                    男性
                                                @break

                                                @default
                                                    回答しない
                                            @endswitch
                                        </p>
                                    </div>

                                    <div class="item-row">
                                        <span class="item-title">身長</span>
                                        <p class="item-content">{{ $detail['tall'] }} cm</p>
                                    </div>

                                    <div class="item-row">
                                        <span class="item-title">足の大きさ</span>
                                        <p class="item-content">{{ $detail['foot'] }} cm</p>
                                    </div>

                                    @if (!empty($detail['stance_name']))
                                        <div class="item-row">
                                            <span class="item-title">スタンス</span>
                                            <p class="item-content">{{ $detail['stance_name'] }}</p>
                                        </div>
                                    @endif

                                    @if ($detail['gear_plan_name'] !== '利用しない')
                                        <div class="item-row">
                                            <span class="item-title">メインギア</span>
                                            <p class="item-content">{{ $detail['gear_plan_name'] }}</p>
                                        </div>
                                    @endif

                                    @if ($detail['wear_plan_name'] !== '利用しない')
                                        <div class="item-row">
                                            <span class="item-title">レンタルウェア</span>
                                            <p class="item-content">
                                                {{ $detail['wear_plan_name'] }}
                                                @if (!empty($detail['wear_size']))
                                                    （{{ $detail['wear_size'] }}）
                                                @endif
                                            </p>
                                        </div>
                                    @endif

                                    @if ($detail['glove_plan_name'] !== '利用しない')
                                        <div class="item-row">
                                            <span class="item-title">レンタルグローブ</span>
                                            <p class="item-content">
                                                {{ $detail['glove_plan_name'] }}
                                                @if (!empty($detail['glove_size']))
                                                    （{{ $detail['glove_size'] }}）
                                                @endif
                                            </p>
                                        </div>
                                    @endif

                                    @if ($detail['goggles_plan_name'] !== '利用しない')
                                        <div class="item-row">
                                            <span class="item-title">レンタルゴーグル</span>
                                            <p class="item-content">{{ $detail['goggles_plan_name'] }}</p>
                                        </div>
                                    @endif

                                    @if ($detail['helmet'])
                                        <div class="item-row">
                                            <span class="item-title">ヘルメット</span>
                                            <p class="item-content">利用する</p>
                                        </div>
                                    @endif

                                    @if (!empty($detail['comment']))
                                        <div class="item-row">
                                            <span class="item-title">個別のご要望</span>
                                            <p class="item-content">{{ $detail['comment'] }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </form>
        </div>

        <div class="button-container">
            <a href="{{ route('client.reservation.detail') }}" class="btn btn-back">戻る</a>
            <a href="#" onclick="document.mainform.submit(); return false;" id="submit-tag"
                class="btn btn-submit">確定</a>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const accordionInputs = document.querySelectorAll('.accordion input[type="radio"]');
            accordionInputs.forEach(input => {
                input.addEventListener('change', function() {
                    document.querySelectorAll('.accordion-content').forEach(content => {
                        if (content.previousElementSibling !== this.nextElementSibling) {
                            content.style.maxHeight = '0';
                        }
                    });
                    if (this.checked) {
                        const accordionItem = this.nextElementSibling;
                        const content = accordionItem.querySelector('.accordion-content');
                        if (content) {
                            content.style.maxHeight = content.scrollHeight + 'px';
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>
