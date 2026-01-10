<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>貸出票</title>
    <style>
        @page {
            margin: 15mm;
        }

        @font-face {
            font-family: 'ipaexg';
            font-style: normal;
            font-weight: normal;
            src: url('{{ storage_path('fonts/ipaexg.ttf') }}') format('truetype');
        }

        @font-face {
            font-family: 'ipaexg';
            font-style: normal;
            font-weight: bold;
            src: url('{{ storage_path('fonts/ipaexg.ttf') }}') format('truetype');
        }

        body {
            font-family: 'ipaexg', sans-serif;
            font-size: 11px;
            color: #333;
        }

        h1 {
            font-size: 18px;
            margin-bottom: 8px;
        }

        h2 {
            font-size: 14px;
            margin: 8px 0 4px;
        }

        .section {
            margin-bottom: 10px;
        }

        .header-table,
        .guest-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table th,
        .header-table td,
        .guest-table th,
        .guest-table td {
            border: 1px solid #999;
            padding: 4px 6px;
            vertical-align: top;
        }

        .header-table th,
        .guest-table th {
            background: #f2f2f2;
        }

        .header-table th {
            width: 25%;
            white-space: nowrap;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .small {
            font-size: 10px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>

    @foreach ($reservations as $idx => $reservation)
        @php
            $repName = trim(($reservation->rep_last_name ?? '') . ' ' . ($reservation->rep_first_name ?? ''));
            $repKana = trim(($reservation->rep_last_name_kana ?? '') . ' ' . ($reservation->rep_first_name_kana ?? ''));
            $visit = $reservation->visit_date ? \Carbon\Carbon::parse($reservation->visit_date)->format('Y-m-d') : '';
            $return = $reservation->return_date
                ? \Carbon\Carbon::parse($reservation->return_date)->format('Y-m-d')
                : '';
            $details = $reservation->details ?? collect();
        @endphp

        {{-- タイトル --}}
        <div class="section">
            <h1>レンタル貸出票</h1>
            <div class="small">
                予約番号：{{ $reservation->id ?? '-' }}
                来店日：{{ $visit }} {{ $reservation->visit_time }}
                作成日時：
                {{ $reservation->printed_at ? $reservation->printed_at->format('Y-m-d H:i') : now()->format('Y-m-d H:i') }}
            </div>
        </div>

        {{-- 代表者・予約情報 --}}
        <div class="section">
            <h2>代表者情報・来店情報</h2>
            <table class="header-table">
                <tr>
                    <th>代表者名</th>
                    <td>{{ $repName }}</td>
                    <th>フリガナ</th>
                    <td>{{ $repKana }}</td>
                </tr>
                <tr>
                    <th>電話番号</th>
                    <td>{{ $reservation->phone }}</td>
                    <th>メールアドレス</th>
                    <td>{{ $reservation->email }}</td>
                </tr>
                <tr>
                    <th>来店予定日</th>
                    <td>{{ $visit }} {{ $reservation->visit_time }}</td>
                    <th>返却予定日</th>
                    <td>{{ $return }}</td>
                </tr>
                <tr>
                    <th>ゲレンデ</th>
                    <td>{{ optional($reservation->resort)->name ?? '未設定' }}</td>
                    <th>最終日ナイター利用</th>
                    <td>{{ $reservation->is_night_use ? '利用する' : '利用しない' }}</td>
                </tr>
                <tr>
                    <th>代表者ご要望</th>
                    <td colspan="3">
                        {{ $reservation->note ?: '（特になし）' }}
                    </td>
                </tr>
            </table>
        </div>

        {{-- 利用者一覧 --}}
        <div class="section">
            <h2>利用者情報</h2>
            <table class="guest-table">
                <thead>
                    <tr class="text-center small">
                        <th>No</th>
                        <th>氏名 / フリガナ</th>
                        <th>区分</th>
                        <th>性別</th>
                        <th>身長(cm)</th>
                        <th>足(cm)</th>
                        <th>メインギア</th>
                        <th>スタンス / Step On</th>
                        <th>ウェア</th>
                        <th>アクセサリ</th>
                        <th>ご要望</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($details as $i => $d)
                        @php
                            $mainMenu = $d->main_gear_menu_id
                                ? \App\Models\RentalMenu::find($d->main_gear_menu_id)
                                : null;
                            $wearMenu = $d->wear_menu_id ? \App\Models\RentalMenu::find($d->wear_menu_id) : null;
                            $gloveMenu = $d->glove_menu_id ? \App\Models\RentalMenu::find($d->glove_menu_id) : null;
                            $goggleMenu = $d->goggle_menu_id ? \App\Models\RentalMenu::find($d->goggle_menu_id) : null;

                            $genderLabel = match ($d->gender ?? null) {
                                'man' => '男性',
                                'woman' => '女性',
                                'none' => '未回答',
                                default => '',
                            };
                            $kubun = $d->is_child ? '子供' : '大人';
                        @endphp
                        <tr class="small">
                            <td class="text-center">{{ $i + 1 }}</td>
                            <td>
                                {{ $d->guest_name }}<br>
                                <span class="small">{{ $d->guest_name_kana }}</span>
                            </td>
                            <td class="text-center">{{ $kubun }}</td>
                            <td class="text-center">{{ $genderLabel }}</td>
                            <td class="text-right">
                                @if (!is_null($d->height))
                                    {{ $d->height }}
                                @endif
                            </td>
                            <td class="text-right">
                                @if (!is_null($d->foot_size))
                                    {{ $d->foot_size }}
                                @endif
                            </td>
                            <td>{{ $mainMenu->name ?? 'なし' }}</td>
                            <td>
                                スタンス: {{ $d->stance ?: '未指定' }}<br>
                                Step On: {{ $d->is_step_on ? '利用する' : '利用しない' }}
                            </td>
                            <td>
                                {{ $wearMenu->name ?? 'なし' }}<br>
                                サイズ: {{ $d->wear_size ?: '未指定' }}
                            </td>
                            <td>
                                ゴーグル: {{ $goggleMenu->name ?? 'なし' }}<br>
                                グローブ: {{ $gloveMenu->name ?? 'なし' }}<br>
                                Gサイズ: {{ $d->glove_size ?: '未指定' }}<br>
                                ヘルメット: {{ $d->is_helmet_used ? '利用する' : '利用しない' }}
                            </td>
                            <td class="small">
                                {{ $d->note ?: '特になし' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center small">
                                利用者情報が登録されていません。
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- 各予約の末尾で改ページ（最後だけスキップ） --}}
        @if ($idx !== count($reservations) - 1)
            <div class="page-break"></div>
        @endif
    @endforeach

</body>

</html>
