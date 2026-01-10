<x-client-layout>
    <x-slot name="seo">
        <title>営業日カレンダー | RENTAL AAA - 営業時間・定休日のご案内 | 岐阜県郡上市高鷲町</title>
        <meta name="description"
            content="RENTAL AAAの営業日カレンダー。平日5:00-18:00、休日2:00-18:30営業。シーズン中無休。高鷲スノーパーク、ダイナランド等周辺ゲレンデ営業日に合わせて対応。事前予約で待ち時間なし。">
    </x-slot>

    <section class="page-header page-header-calendar">
        <div class="container">
            <h1>営業日カレンダー</h1>
            <p>2025-2026シーズン</p>
        </div>
    </section>

    <section class="calendar-section">
        <div class="container">
            <div class="calendar-intro">
                <h2 class="desktop-only-contents">営業期間：2025年12月13日〜2026年4月5日</h2>
                <div class="calendar-legend">
                    @foreach($patterns as $pattern)
                        <div class="legend-item">
                            <span class="legend-color" style="background-color: {{ $pattern->color }}"></span>
                            <span>{{ $pattern->name }}（{{ \Carbon\Carbon::parse($pattern->open_time)->format('H:i') }}-{{ \Carbon\Carbon::parse($pattern->close_time)->format('H:i') }}）</span>
                        </div>
                    @endforeach
                    <div class="legend-item">
                        <span class="legend-color closed"></span>
                        <span>営業期間外</span>
                    </div>
                </div>
            </div>

            @foreach($months as $monthData)
                <div class="calendar-month">
                    <h3 class="month-title">{{ $monthData['year'] }}年{{ $monthData['month'] }}月</h3>
                    <div class="calendar-grid">
                        <div class="calendar-weekday">日</div>
                        <div class="calendar-weekday">月</div>
                        <div class="calendar-weekday">火</div>
                        <div class="calendar-weekday">水</div>
                        <div class="calendar-weekday">木</div>
                        <div class="calendar-weekday">金</div>
                        <div class="calendar-weekday">土</div>

                        @foreach($monthData['days'] as $dayData)
                            @if(isset($dayData['empty']))
                                <div class="calendar-day empty"></div>
                            @else
                                @php
                                    $pattern = $dayData['pattern'];
                                    $cssClass = 'calendar-day';
                                    $style = '';

                                    if ($pattern && $pattern->is_open) {
                                        // 営業日の場合、背景色を設定
                                        $style = 'background-color: ' . $pattern->color . ';';
                                    } else {
                                        // 休業日または未設定の場合
                                        $cssClass .= ' closed';
                                    }
                                @endphp
                                <div class="{{ $cssClass }}" @if($style) style="{{ $style }}" @endif>
                                    <div class="calendar-day-number">{{ $dayData['day'] }}</div>
                                    @if($pattern && $pattern->is_open)
                                        <div class="calendar-day-time">
                                            {{ \Carbon\Carbon::parse($pattern->open_time)->format('H:i') }}-{{ \Carbon\Carbon::parse($pattern->close_time)->format('H:i') }}
                                        </div>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>
                    @if($monthData['month'] == 4)
                        <p class="season-end-note">※4月6日以降はシーズン終了のため休業いたします</p>
                    @endif
                </div>
            @endforeach

            <div class="calendar-notes">
                <h3>ご注意事項</h3>
                <ul>
                    <li>営業日、営業時間は天候や雪の状況により変更される場合がございます。</li>
                    <li>シーズン初め、年末年始、シーズン終わりは特別営業時間となります。</li>
                    <li>ハイシーズンは大変混雑するため、レンタル品をご用意できないことがあります。事前のご予約をおすすめいたします。</li>
                </ul>
            </div>

            <div class="calendar-cta">
                <div class="cta-buttons">
                    <a href="https://takasuaaa.xsrv.jp/reservation/agree" class="btn-reservation">今すぐ予約する</a>
                    <a href="{{ route('home') }}" class="btn-back">TOPページへ戻る</a>
                </div>
            </div>
        </div>
    </section>
</x-client-layout>
