<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <style>
        body {
            font-family: sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        h1 {
            font-size: 20px;
            color: #333;
        }

        h2 {
            font-size: 16px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 5px;
            margin-top: 20px;
        }

        h3 {
            font-size: 14px;
            margin-top: 15px;
            font-weight: bold;
            background-color: #eee;
            padding: 5px;
        }

        p {
            margin: 5px 0;
            font-size: 14px;
            line-height: 1.5;
        }

        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>

<body>

    <h1>
        {{ $reservation->rep_last_name }} {{ $reservation->rep_first_name }} 様
    </h1>
    <p>
        この度はレンタルトリプルエーのご利用、誠にありがとうございます。
    </p>
    <p>
        下記の内容でご予約を変更いたしました。当日のご予約番号は「{{ $reservation->build_number }}」番です。
    </p>
    <p>
        来店当日は代表者の身分証明証が必要になります。
        ご準備いただき足元にお気をつけの上ご来店ください。
    </p>
    {{-- キャンセル用ルートは未定義のためプレースホルダーにしています --}}
    <p>
        ご予約のキャンセルは<a
            href="{{ route('client.reservation.cancel.show', ['token' => $reservation->token]) }}">コチラ</a>よりお手続きください。
        当日におきましても、キャンセル料金はいただいておりません。

        <a href="{{ route('client.reservation.cancel.show', ['token' => $reservation->token]) }}">予約のキャンセルはこちら</a>
    </p>

    <h2>＜代表者情報＞</h2>

    <p>【氏名】 {{ $reservation->rep_last_name }} {{ $reservation->rep_first_name }}</p>
    <p>【E-mail】 {{ $reservation->email }}</p>
    <p>【電話番号】 {{ $reservation->phone }}</p>
    <p>【来店日時】 {{ \Carbon\Carbon::parse($reservation->visit_date)->format('Y-m-d') }}
        {{ \Carbon\Carbon::parse($reservation->visit_time)->format('H:i') }}</p>
    <p>【返却日時】 {{ \Carbon\Carbon::parse($reservation->return_date)->format('Y-m-d') }}</p>
    <p>【ナイター】 {{ $reservation->is_last_night_nighter ? '利用する' : '利用しない' }}</p>
    {{-- Resortモデルへのリレーションが必要です --}}
    <p>【ゲレンデ】 {{ $reservation->resort->name ?? '未定' }}</p>
    <p>【備考】 {{ $reservation->note }}</p>
    <br>

    <h2>＜利用者情報＞</h2>
    @foreach ($reservation->details as $detail)
        <h3>
            利用者 {{ $loop->iteration }}：{{ $detail->guest_name }} 様
        </h3>
        {{-- 性別はコントローラーで文字列として保存されています --}}
        <p>性別：
            @switch($detail->gendar)
                @case(0)
                    男性
                @break

                @case(1)
                    女性
                @break

                @default
                    回答しない
            @endswitch
        </p>

        <p>区分：{{ $detail->is_child ? '子供' : '大人' }}</p>

        <p>身長：{{ $detail->height }} cm</p>
        <p>ブーツサイズ：{{ $detail->foot_size }} cm</p>

        @if ($detail->stance)
            <p>スタンス：{{ $detail->stance }}</p>
        @endif

        {{-- 以下は各Menuモデルへのリレーション(belongsTo)が定義されている前提です --}}
        @if ($detail->main_gear_menu_id)
            <p>レンタルギア：{{ $detail->mainGearMenu->name ?? '未選択' }}</p>
        @endif

        @if ($detail->wear_menu_id)
            <p>レンタルウェア：{{ $detail->wearMenu->name ?? '未選択' }} (サイズ: {{ $detail->wear_size }})</p>
        @endif

        @if ($detail->glove_menu_id)
            <p>レンタルグローブ：{{ $detail->gloveMenu->name ?? '未選択' }} (サイズ: {{ $detail->glove_size }})</p>
        @endif

        @if ($detail->goggle_menu_id)
            <p>レンタルゴーグル：{{ $detail->goggleMenu->name ?? '未選択' }}</p>
        @endif

        @if ($detail->is_helmet_used)
            <p>ヘルメット：利用する</p>
        @endif

        @if ($detail->is_step_on)
            <p>Step On：利用する</p>
        @endif

        {{-- 現在のテーブル構造にticketカラムがないためコメントアウト
        @if ($detail->ticket)
            <p>リフト券：購入する</p>
        @endif
        --}}

        @if ($detail->note)
            <p>備考：{{ $detail->note }}</p>
        @endif
        <hr style="border:none; border-top:1px dashed #ccc;">
    @endforeach

</body>

</html>
