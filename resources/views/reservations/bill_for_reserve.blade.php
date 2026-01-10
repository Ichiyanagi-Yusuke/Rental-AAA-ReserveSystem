@php
    // 利用日数を計算
    $visitDate = \Carbon\Carbon::parse($reservation->visit_date);
    $returnDate = \Carbon\Carbon::parse($reservation->return_date);
    $useDays = $visitDate->diffInDays($returnDate);

    // レンタル品の集計（メニュー名ごとにカウント）
    $itemCounts = [];
    $helmetCount = 0;

    foreach ($reservation->details as $detail) {
        // メインギア
        if ($detail->mainGearMenu && $detail->mainGearMenu->name !== '利用しない') {
            $name = $detail->mainGearMenu->name;
            $itemCounts[$name] = ($itemCounts[$name] ?? 0) + 1;
        }
        // ウェア
        if ($detail->wearMenu && $detail->wearMenu->name !== '利用しない') {
            $name = $detail->wearMenu->name;
            $itemCounts[$name] = ($itemCounts[$name] ?? 0) + 1;
        }
        // グローブ
        if ($detail->gloveMenu && $detail->gloveMenu->name !== '利用しない') {
            $name = $detail->gloveMenu->name;
            $itemCounts[$name] = ($itemCounts[$name] ?? 0) + 1;
        }
        // ゴーグル
        if ($detail->goggleMenu && $detail->goggleMenu->name !== '利用しない') {
            $name = $detail->goggleMenu->name;
            $itemCounts[$name] = ($itemCounts[$name] ?? 0) + 1;
        }
        // ヘルメット
        if ($detail->is_helmet_used) {
            $helmetCount++;
        }
    }

    $listCount = count($itemCounts) + ($helmetCount > 0 ? 1 : 0);
    $detailCount = $reservation->details->count();
@endphp
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title></title>
    <style>
        /* 基本の文字 */

        @font-face {
            font-family: 'ipaexg';
            font-style: normal;
            font-weight: normal;

            /* ローカル実行パス */
            /* src: url('{{ asset('storage/fonts/ipaexg.ttf') }}') format('truetype'); */

            /* サーバー実行パス */
            src: url('{{ storage_path('fonts/ipaexg.ttf') }}') format('truetype');
        }

        /* 全てのHTML要素に適用 */
        html,
        body,
        textarea,
        table {
            color: #464646;
            font-family: 'ipaexg';
        }

        body {
            width: 186mm;
            height: 297mm;
            font-size: 12px;
            text-align: center;
        }

        span.size-8mm {
            font-size: 8mm;
            letter-spacing: 1mm;
        }

        span.size-4mm {
            font-size: 4mm;
        }

        .title-area {
            width: 100%;
            height: 100%;
        }

        .pd-l-5mm {
            padding-left: 5mm;
        }

        .reserve-index-area {
            width: 50%;
            height: 80mm;
        }

        .reserve-detail-area {
            width: 50%;
            height: 80mm;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            width: 50%;
            text-align: center;
            height: 6mm;
            word-break: break-all;
            word-wrap: break-word;
        }

        .line-on,
        .line-on td {
            border: 1px solid #333;
        }

        .item-name {
            width: auto;
        }

        .reserve-num {
            width: 15mm;
        }

        .add-num {
            width: 15mm;

        }

        .reserve-detail-table {
            width: 100%;
        }

        .first-table {
            height: 83mm;
            width: 100%;
        }

        .sub-content {
            padding-top: 3mm;
            height: 9mm;
        }

        .rental-list-h {
            height: 7mm;
            padding-top: 1mm;
            font-size: 4mm;
        }

        .detail-item-name {
            width: 70mm;
        }

        .seq {
            width: 10mm;
        }

        .detail-name {
            width: 30mm;
            height: 14mm;
        }

        .tall {
            width: 12mm;
        }

        .foot {
            width: 12mm;
        }

        .stance {
            width: 8mm;
        }

        .gear {
            width: 40mm;

        }

        .detail-item-name {
            width: 10mm;
        }

        .glove {
            width: 10mm;
        }

        .goggles {
            width: 10mm;
        }

        .helmet {
            width: 10mm;
        }

        .agree {
            width: 8mm;
        }

        .agree-title,
        .reserver-title {
            height: 8mm;
            padding-top: 2mm;
            font-size: 4mm;
            text-decoration: underline;
        }

        .r-side {
            text-align: right;
            width: 30mm;
        }

        .l-side {
            text-align: left;
        }

        .txt-c {
            text-align: center;
        }

        .height5mm {
            height: 5mm;
        }

        .height10mm {

            height: 10mm;
            padding-top: 3mm;
        }

        .detail-list {
            font-size: 4mm;
            text-decoration: underline;
        }

        .other {
            width: 43mm;
            font-size: 2.5mm;
            text-align: left;
        }

        .build-info {
            font-size: 8mm;
        }

        .build-info-tr {
            height: 15mm;
        }

        .build-info-date {
            font-size: 3mm;
            text-align: right;
        }


        .ddd {
            /* padding-top: 6mm; */
        }

        .line-on-dot {
            border: 1px dashed #999;
        }

        .build-plan-name {
            font-size: 5mm;
        }
    </style>
</head>

<body>
    <span class="size-8mm">{{ $reservation->rep_last_name }} 様 Rental AAA 予約貸出伝票</span>
    <span class="size-8mm pd-l-5mm">({{ $reservation->build_number }})</span>
    <div class="sub-content">
        <div>
            <span
                class="size-4mm">貸出日:　{{ $reservation->visit_date->format('Y-m-d') }}　-　{{ $reservation->visit_time instanceof \Carbon\Carbon ? $reservation->visit_time->format('H:i') : $reservation->visit_time }}</span>&nbsp;&nbsp;
            <span
                class="size-4mm">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="size-4mm">利用日数:
                @if ($useDays == 0)
                    当日のみ
                @else
                    {{ $useDays }}日間
                @endif

            </span>&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="size-4mm">担当：</span>


        </div>

    </div>
    <div class="first-table">


        <table>
            <tr class="">
                <td class="reserve-index-area">
                    <div class="rental-list-h">
                        レンタル品リスト
                    </div>
                    <table class="reserve-detail-table line-on">
                        <tr class="">
                            <td>品名</td>
                            <td>数量</td>
                            <td>追加数</td>
                        </tr>
                        @foreach ($itemCounts as $itemName => $count)
                            <tr class="">
                                <td class="item-name">{{ $itemName }}</td>
                                <td class="reserve-num">{{ $count }}</td>
                                <td class="add-num"></td>

                            </tr>
                        @endforeach
                        @if ($helmetCount !== 0)
                            <tr class="">
                                <td class="item-name">ヘルメット</td>
                                <td class="reserve-num">{{ $helmetCount }}</td>
                                <td class="add-num"></td>
                            </tr>
                        @endif
                        @for ($val = $listCount; $val < 10; $val++)
                            <tr class="">
                                <td class="item-name"></td>
                                <td class="reserve-num"></td>
                                <td class="add-num"></td>
                            </tr>
                        @endfor
                    </table>
                </td>
                <td class="reserve-detail-area">
                    <div class="reserver-title">
                        代表者情報
                    </div>
                    <table>
                        <tr class="">
                            <td class="r-side">氏名：</td>
                            <td class="l-side">{{ $reservation->rep_last_name }} {{ $reservation->rep_first_name }}
                                様&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;本人確認&nbsp;[&nbsp;]</td>
                        </tr>
                        <tr class="">
                            <td class="r-side">フリガナ：</td>
                            <td class="l-side">{{ $reservation->rep_last_name_kana }}
                                {{ $reservation->rep_first_name_kana }}　様</td>
                        </tr>
                        <tr class="">
                            <td class="r-side">電話番号：</td>
                            <td class="l-side">{{ $reservation->phone }}</td>

                        </tr>
                        <tr class="">
                            <td class="r-side">コメント：</td>
                            <td class="l-side">
                                @if ($reservation->note == '' || is_null($reservation->note))
                                    特に無し
                                @else
                                    {{ $reservation->note }}
                                @endif
                            </td>
                        </tr>
                    </table>
                    <table>

                        <tr class="">
                            <td class="agree-title">同意事項</td>
                        </tr>
                        <tr class="">
                            <td>レンタル品使用中での怪我、事故の補償等は自己責任となり</td>
                        </tr>
                        <tr>
                            <td>当店からの補償は一切ございません。</td>
                        </tr>
                        <tr>
                            <td>レンタル品の盗難、紛失、</td>
                        </tr>
                        <tr>
                            <td>不注意等によるレンタル品の損害に関しては</td>
                        </tr>
                        <tr>
                            <td>相当額の費用をお支払いいただきます。</td>
                        </tr>
                    </table>

                </td>
            </tr>
        </table>
    </div>

    <div class="height10mm"><span class="detail-list">利用者リスト・レンタル詳細</span>
    </div>

    <div class="sss">

        <table class="reserve-detail-table line-on">
            <tr class="">
                <td class="height5mm seq">No</td>
                <td class="height5mm detail-name">氏名</td>
                <td class="height5mm tall">身長</td>
                <td class="height5mm foot">足</td>
                <td class="height5mm stance">S</td>
                <td class="height5mm gear">ギア</td>
                <td class="height5mm other">その他</td>
                <td class="height5mm price">金額</td>
                <td class="height5mm agree">同意</td>

            </tr>
            @foreach ($reservation->details as $detail)
                <tr class="">
                    <td class="seq">{{ $loop->iteration }}</td>
                    <td class="detail-name">{{ $detail->guest_name }}</td>
                    <td class="tall">{{ $detail->height }}</td>
                    <td class="foot">{{ $detail->foot_size }}</td>
                    <td class="stance">
                        @if ($detail->stance === 'レギュラー')
                            R
                        @elseif ($detail->stance === 'グーフィー')
                            G
                        @else
                            -
                        @endif
                    </td>
                    <td class="gear l-side">
                        @if (!is_null($detail->mainGearMenu))
                            @if ($detail->mainGearMenu->name !== '利用しない')
                                {{ $detail->mainGearMenu->name }}<br>Model No :
                            @endif
                        @endif
                    </td>
                    <td class="other">
                        @if (!is_null($detail->wearMenu))
                            @if ($detail->wearMenu->name !== '利用しない')
                                W：{{ $detail->wearMenu->name }}({{ $detail->wear_size }})<br>
                            @endif
                        @endif
                        @if (!is_null($detail->gloveMenu))
                            @if ($detail->gloveMenu->name !== '利用しない')
                                GL：{{ $detail->gloveMenu->name }}({{ $detail->glove_size }})<br>
                            @endif
                        @endif
                        @if (!is_null($detail->goggleMenu))
                            @if ($detail->goggleMenu->name !== '利用しない')
                                GG：{{ $detail->goggleMenu->name }}<br>
                            @endif
                        @endif
                        @if ($detail->is_helmet_used)
                            ヘルメット
                        @endif
                    </td>
                    <td class="price">
                    </td>
                    <td class="agree">[ ]</td>

                </tr>
            @endforeach
            @for ($val = $detailCount; $val < 10; $val++)
                <tr class="">
                    <td class="seq"></td>
                    <td class="detail-name"></td>
                    <td class="tall"></td>
                    <td class="foot"></td>
                    <td class="stance">
                    </td>
                    <td class="gear l-side"><br></td>
                    <td class="other">
                    </td>
                    <td class="price">
                    </td>
                    <td class="agree">[ ]</td>

                </tr>
            @endfor

        </table>
    </div>
</body>

<body>
    <table class="">
        @foreach ($reservation->details as $detail)
            @if (!is_null($detail->mainGearMenu))
                @if ($detail->mainGearMenu->name !== '利用しない')
                    <tr>
                        <td>
                            <table class="build-info line-on-dot">
                                <tr>
                                    <td class="build-info-date">
                                        {{ $reservation->visit_date->format('Y-m-d') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="build-info-tr ddd">
                                        {{ $reservation->build_number }}-{{ $loop->iteration }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="build-plan-name">{{ $detail->mainGearMenu->name }}</td>
                                </tr>
                                <tr>
                                    <td class="build-info-tr">
                                        {{ $detail->height }}／{{ $detail->foot_size }} -
                                        @if ($detail->stance === 'レギュラー')
                                            R
                                        @elseif ($detail->stance === 'グーフィー')
                                            G
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </td>


                        <td>
                            <table class="build-info line-on-dot">
                                <tr>
                                    <td class="build-info-date">
                                        {{ $reservation->visit_date->format('Y-m-d') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="build-info-tr ddd">
                                        {{ $reservation->build_number }}-{{ $loop->iteration }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="build-plan-name">{{ $detail->mainGearMenu->name }}</td>
                                </tr>
                                <tr>
                                    <td class="build-info-tr">
                                        {{ $detail->height }}／{{ $detail->foot_size }} -
                                        @if ($detail->stance === 'レギュラー')
                                            R
                                        @elseif ($detail->stance === 'グーフィー')
                                            G
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </td>

                    </tr>
                @endif
            @endif
        @endforeach

    </table>
</body>

</html>
