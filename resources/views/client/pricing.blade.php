<x-client-layout>
    <x-slot name="seo">
        <title>レンタル料金詳細 | RENTAL AAA - スキー・スノーボードレンタル料金表 | Burton STEP ON対応</title>
        <meta name="description"
            content="RENTAL AAAのレンタル料金詳細ページ。Burton STEP ONセット¥4,500、スノーボードセット¥3,500～、スキーセット¥3,500～。セット割引や単品レンタルも充実。高鷲スノーパーク、ダイナランド等周辺ゲレンデご利用に最適。">
        <meta name="keywords" content="レンタル料金,スキーレンタル料金,スノーボードレンタル料金,Burton STEP ON,料金表,岐阜県,郡上市,高鷲町,セット割引,単品レンタル">
        <meta name="robots" content="index, follow">

        <meta property="og:type" content="website">
        <meta property="og:title" content="レンタル料金詳細 | RENTAL AAA">
        <meta property="og:description"
            content="Burton STEP ONセット¥4,500、スノーボードセット¥3,500～、スキーセット¥3,500～。セット割引や単品レンタルも充実。">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:site_name" content="RENTAL AAA">
        <meta property="og:image" content="{{ asset('images/client/ogp-image.jpg') }}">
        <meta property="og:locale" content="ja_JP">

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="レンタル料金詳細 | RENTAL AAA">
        <meta name="twitter:description" content="Burton STEP ONセット¥4,500、スノーボードセット¥3,500～、スキーセット¥3,500～。">
        <meta name="twitter:image" content="{{ asset('images/client/ogp-image.jpg') }}">
    </x-slot>

    <!-- ページヘッダー -->
    <section class="page-header page-header-pricing">
        <div class="container">
            <h1>レンタル料金</h1>
            <p>Rental Pricing</p>
        </div>
    </section>

    <!-- 料金表セクション -->
    <section class="pricing-detail-section">
        <div class="container">
            <!-- セットレンタル -->
            <div class="pricing-category">
                <h3 class="subcategory-title">
                    <!-- <span class="title-icon">⛷️</span> -->
                    セットレンタル
                </h3>
                <p class="category-description">初めての方や手ぶらで楽しみたい方におすすめのお得なセットプランです。</p>

                <div class="price-table-wrapper">
                    <table class="price-table">
                        <thead>
                            <tr>
                                <th class="item-name">商品名</th>
                                <th class="price-col">1日料金</th>
                                <th class="price-col">2日料金</th>
                                <th class="price-col">3日料金</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="featured-row">
                                <td class="item-name">
                                    <strong>BurtonCustomセット</strong>
                                    <span class="item-badge premium">プレミアム</span>
                                    <p class="item-description">ボード・ブーツ・バインディング</p>
                                    <p class="item-description">+ ¥500/day で StepOn にアップグレード! </p>
                                </td>
                                <td class="price-col">¥4,500</td>
                                <td class="price-col">¥9,000</td>
                                <td class="price-col">¥13,500</td>
                            </tr>
                            <tr>
                                <td class="item-name">
                                    <strong>New Model Burtonセット</strong>
                                    <span class="item-badge popular">人気</span>
                                    <p class="item-description">ボード・ブーツ・バインディング</p>
                                    <p class="item-description">+ ¥500/day で StepOn にアップグレード! </p>

                                </td>
                                <td class="price-col">¥4,000</td>
                                <td class="price-col">¥7,500</td>
                                <td class="price-col">¥11,000</td>
                            </tr>
                            <tr>
                                <td class="item-name">
                                    <strong>Burtonスノーボードセット</strong>
                                    <span class="item-badge popular">人気</span>
                                    <p class="item-description">ボード・ブーツ・バインディング</p>
                                </td>
                                <td class="price-col">¥3,500</td>
                                <td class="price-col">¥6,500</td>
                                <td class="price-col">¥9,500</td>
                            </tr>
                            <tr>
                                <td class="item-name">
                                    <strong>スキーセット</strong>
                                    <span class="item-badge popular">人気</span>
                                    <p class="item-description">スキー・ブーツ・ストック</p>
                                </td>
                                <td class="price-col">¥3,500</td>
                                <td class="price-col">¥6,500</td>
                                <td class="price-col">¥9,500</td>
                            </tr>
                            <tr>
                                <td class="item-name">
                                    <strong>ショートスキーセット</strong>
                                    <p class="item-description">ショートスキー・ブーツ・（ストック）</p>
                                </td>
                                <td class="price-col">¥3,500</td>
                                <td class="price-col">¥6,500</td>
                                <td class="price-col">¥9,500</td>
                            </tr>
                            <tr>
                                <td class="item-name">
                                    <strong>ウエア（上下）</strong>
                                    <p class="item-description">ジャケット・パンツ</p>
                                </td>
                                <td class="price-col">¥3,000</td>
                                <td class="price-col">¥5,500</td>
                                <td class="price-col">¥8,000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- ジュニアセット -->
                <h3 class="subcategory-title">ジュニア向けセット</h3>
                <div class="price-table-wrapper">
                    <table class="price-table">
                        <thead>
                            <tr>
                                <th class="item-name">商品名</th>
                                <th class="price-col">1日料金</th>
                                <th class="price-col">2日料金</th>
                                <th class="price-col">3日料金</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="item-name">
                                    <strong>Jr.ボードセット</strong>
                                    <p class="item-description">ボード・ブーツ・バインディング</p>
                                    <p class="item-description">+ ¥500/day で StepOn にアップグレード! </p>

                                </td>
                                <td class="price-col">¥3,000</td>
                                <td class="price-col">¥5,500</td>
                                <td class="price-col">¥8,000</td>
                            </tr>
                            <tr>
                                <td class="item-name">
                                    <strong>Jr.スキーセット</strong>
                                    <p class="item-description">スキー・ブーツ・ストック</p>
                                </td>
                                <td class="price-col">¥3,000</td>
                                <td class="price-col">¥5,500</td>
                                <td class="price-col">¥8,000</td>
                            </tr>
                            <tr>
                                <td class="item-name">
                                    <strong>Jr.ウエア（上下）</strong>
                                    <p class="item-description">ジャケット・パンツ</p>
                                </td>
                                <td class="price-col">¥2,500</td>
                                <td class="price-col">¥4,500</td>
                                <td class="price-col">¥6,500</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 単品レンタル -->
            <div class="pricing-category">
                <h3 class="subcategory-title">
                    <!-- <span class="title-icon">🎿</span> -->
                    単品レンタル
                </h3>
                <p class="category-description">お持ちの装備と組み合わせて、必要なアイテムだけレンタルできます。</p>

                <div class="price-table-wrapper">
                    <table class="price-table">
                        <thead>
                            <tr>
                                <th class="item-name">商品名</th>
                                <th class="price-col">1日料金</th>
                                <th class="price-col">2日料金</th>
                                <th class="price-col">3日料金</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="category-header">
                                <td colspan="4">スノーボード</td>
                            </tr>
                            <tr>
                                <td class="item-name">
                                    <strong>BurtonCustom</strong>
                                    <span class="item-badge premium">プレミアム</span>
                                </td>
                                <td class="price-col">¥3,500</td>
                                <td class="price-col">¥7,000</td>
                                <td class="price-col">¥10,500</td>
                            </tr>
                            <tr>
                                <td class="item-name"><strong>New Model Burton</strong></td>
                                <td class="price-col">¥3,000</td>
                                <td class="price-col">¥5,500</td>
                                <td class="price-col">¥8,000</td>
                            </tr>
                            <tr>
                                <td class="item-name"><strong>Burtonスノーボード</strong></td>
                                <td class="price-col">¥2,500</td>
                                <td class="price-col">¥4,500</td>
                                <td class="price-col">¥6,500</td>
                            </tr>
                            <tr>
                                <td class="item-name"><strong>ボードブーツ</strong></td>
                                <td class="price-col">¥2,000</td>
                                <td class="price-col">¥3,500</td>
                                <td class="price-col">¥5,000</td>
                            </tr>

                            <tr class="category-header">
                                <td colspan="4">スキー</td>
                            </tr>
                            <tr>
                                <td class="item-name"><strong>スキー</strong></td>
                                <td class="price-col">¥2,500</td>
                                <td class="price-col">¥4,500</td>
                                <td class="price-col">¥7,500</td>
                            </tr>
                            <tr>
                                <td class="item-name"><strong>ショートスキー</strong></td>
                                <td class="price-col">¥2,500</td>
                                <td class="price-col">¥4,500</td>
                                <td class="price-col">¥7,500</td>
                            </tr>
                            <tr>
                                <td class="item-name"><strong>スキーブーツ</strong></td>
                                <td class="price-col">¥2,000</td>
                                <td class="price-col">¥3,500</td>
                                <td class="price-col">¥5,000</td>
                            </tr>
                            <tr>
                                <td class="item-name"><strong>ストック</strong></td>
                                <td class="price-col">¥300</td>
                                <td class="price-col">¥500</td>
                                <td class="price-col">¥800</td>
                            </tr>

                            <tr class="category-header">
                                <td colspan="4">ウエア</td>
                            </tr>
                            <tr>
                                <td class="item-name"><strong>ウエア単品</strong></td>
                                <td class="price-col">¥2,000</td>
                                <td class="price-col">¥3,500</td>
                                <td class="price-col">¥5,000</td>
                            </tr>
                            <tr>
                                <td class="item-name"><strong>グローブ</strong></td>
                                <td class="price-col">¥300</td>
                                <td class="price-col">¥500</td>
                                <td class="price-col">¥800</td>
                            </tr>
                            <tr>
                                <td class="item-name"><strong>革グローブ</strong></td>
                                <td class="price-col">¥500</td>
                                <td class="price-col">¥800</td>
                                <td class="price-col">¥1000</td>
                            </tr>
                            <tr>
                                <td class="item-name"><strong>ゴーグル</strong></td>
                                <td class="price-col">¥300</td>
                                <td class="price-col">¥500</td>
                                <td class="price-col">¥800</td>
                            </tr>
                            <tr>
                                <td class="item-name"><strong>Newゴーグル</strong>
                                    <p class="item-description">※比較的キズの少ないレンタル品です。</p>
                                </td>
                                <td class="price-col">¥500</td>
                                <td class="price-col">¥800</td>
                                <td class="price-col">¥1000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- ジュニア単品 -->
                <h3 class="subcategory-title">ジュニア向け単品</h3>
                <div class="price-table-wrapper">
                    <table class="price-table">
                        <thead>
                            <tr>
                                <th class="item-name">商品名</th>
                                <th class="price-col">1日料金</th>
                                <th class="price-col">2日料金</th>
                                <th class="price-col">3日料金</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="item-name"><strong>Jr.スノーボード</strong></td>
                                <td class="price-col">¥2,000</td>
                                <td class="price-col">¥3,500</td>
                                <td class="price-col">¥5,000</td>
                            </tr>
                            <tr>
                                <td class="item-name"><strong>Jr.スキー</strong></td>
                                <td class="price-col">¥2,000</td>
                                <td class="price-col">¥3,500</td>
                                <td class="price-col">¥5,000</td>
                            </tr>
                            <tr>
                                <td class="item-name"><strong>Jr.ボードブーツ</strong></td>
                                <td class="price-col">¥1,500</td>
                                <td class="price-col">¥2,500</td>
                                <td class="price-col">¥3,500</td>
                            </tr>
                            <tr>
                                <td class="item-name"><strong>Jr.スキーブーツ</strong></td>
                                <td class="price-col">¥1,500</td>
                                <td class="price-col">¥2,500</td>
                                <td class="price-col">¥3,500</td>
                            </tr>
                            <tr>
                                <td class="item-name"><strong>Jr.ウエア単品</strong></td>
                                <td class="price-col">¥1,500</td>
                                <td class="price-col">¥2,500</td>
                                <td class="price-col">¥3,500</td>
                            </tr>
                            <tr>
                                <td class="item-name"><strong>Jr.ストック</strong></td>
                                <td class="price-col">¥300</td>
                                <td class="price-col">¥500</td>
                                <td class="price-col">¥800</td>
                            </tr>
                            <tr>
                                <td class="item-name"><strong>Jr.グローブ</strong></td>
                                <td class="price-col">¥300</td>
                                <td class="price-col">¥500</td>
                                <td class="price-col">¥800</td>
                            </tr>
                            <tr>
                                <td class="item-name"><strong>Jr.ゴーグル</strong></td>
                                <td class="price-col">¥300</td>
                                <td class="price-col">¥500</td>
                                <td class="price-col">¥800</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 料金に関する注意事項 -->
            <div class="pricing-notes">
                <h3>料金に関するご案内</h3>
                <div class="notes-grid">
                    <div class="note-item">
                        <h4>💳 お支払い方法</h4>
                        <p>現金、各種クレジットカード、電子マネー、QR決済がご利用いただけます。</p>
                    </div>
                    <div class="note-item">
                        <h4>🆔 身分証明書</h4>
                        <p>レンタルの際には身分証明書（運転免許証、保険証、マイナンバー、パスポート等）のご提示をお願いしております。</p>
                    </div>
                    <div class="note-item">
                        <h4>✉️ 事前予約</h4>
                        <p>混雑時の待ち時間短縮のため、事前予約をおすすめしております。</p>
                    </div>
                    <div class="note-item">
                        <h4>⚠️ キャンセルについて</h4>
                        <p>予約のキャンセルは前日17:00まで無料です。当日キャンセルの場合、キャンセル料が発生する場合がございます。</p>
                    </div>
                </div>
            </div>

            <!-- CTA -->
            <div class="pricing-cta">
                <h2>ご予約はこちらから</h2>
                <p>オンライン予約で待ち時間なしでレンタルできます</p>
                <div class="cta-buttons">
                    <a href="https://takasuaaa.xsrv.jp/reservation/agree" class="btn-reservation">今すぐ予約する</a>
                    <a href="/" class="btn-back">TOPページへ戻る</a>
                </div>
            </div>
        </div>
    </section>
</x-client-layout>
