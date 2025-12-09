<x-client-layout>
    <x-slot name="seo">
        <!-- SEO基本設定 -->
        <title>
            お知らせ・ブログ | RENTAL AAA - 最新情報・キャンペーン情報 |
            岐阜県郡上市高鷲町
        </title>
        <meta name="description"
            content="RENTAL AAAのお知らせ・ブログページ。シーズン営業開始情報、最新モデル入荷情報、Burton STEP ON情報、キャンペーン情報など最新ニュースをお届け。高鷲スノーパーク、ダイナランドご利用前にチェック。" />
        <meta name="keywords" content="お知らせ,ブログ,ニュース,最新情報,キャンペーン,Burton STEP ON,岐阜県,郡上市,高鷲町,スキーレンタル,スノーボードレンタル" />
        <meta name="robots" content="index, follow" />
        <link rel="canonical" href="https://rental-aaa.jp/news.html" />

        <!-- OGP設定 -->
        <meta property="og:type" content="website" />
        <meta property="og:title" content="お知らせ・ブログ | RENTAL AAA" />
        <meta property="og:description" content="シーズン営業開始情報、最新モデル入荷情報、Burton STEP ON情報など最新ニュースをお届け。" />
        <meta property="og:url" content="https://rental-aaa.jp/news.html" />
        <meta property="og:site_name" content="RENTAL AAA" />
        <meta property="og:image" content="https://rental-aaa.jp/ogp-image.jpg" />

        <!-- Twitter Card -->
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" content="お知らせ・ブログ | RENTAL AAA" />
        <meta name="twitter:description" content="シーズン営業開始情報、最新モデル入荷情報など最新ニュースをお届け。" />

        <link rel="stylesheet" href="/html/new_page/css/style.css" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;700;900&family=Oswald:wght@400;700&display=swap"
            rel="stylesheet" />
    </x-slot>

    <!-- ページヘッダー -->
    <section class="page-header page-header-news">
        <div class="container">
            <h1>NEWS & BLOG</h1>
            <p>お知らせとブログ</p>
        </div>
    </section>

    <!-- カテゴリーフィルター -->
    <section class="news-filter-section">
        <div class="container">
            <div class="filter-buttons">
                <button class="filter-btn active" data-category="all">
                    すべて
                </button>
                <button class="filter-btn" data-category="news">
                    お知らせ
                </button>
                <button class="filter-btn" data-category="blog">ブログ</button>
                <button class="filter-btn" data-category="event">
                    イベント
                </button>
            </div>
        </div>
    </section>

    <!-- ニュース一覧 -->
    <section class="news-list-section">
        <div class="container">
            <div class="news-list">
                <!-- 記事1 -->
                <article class="news-list-item" data-category="news">
                    <div class="news-list-image"
                        style="
                            background-image: url('{{ asset('images/client/top_news_new.jpg') }}');
                            background-size: cover;
                        ">
                    </div>
                    <div class="news-list-content">
                        <div class="news-list-meta">
                            <span class="news-date">2025.12.04</span>
                            <span class="news-category-tag news-tag">お知らせ</span>
                        </div>
                        <h2 class="news-list-title">Webサイトリニューアル</h2>
                        <p class="news-list-excerpt">
                            レンタルトリプルエーの公式webサイトをリニューアルしました。より使いやすく、より見やすく。新しいデザインでお客様をお迎えします。お客様により快適にご利用いただけるよう、デザイン・機能・コンテンツの全てを刷新いたしました。
                        </p>
                        <a href="/news/2" class="news-read-more">続きを読む →</a>
                    </div>
                </article>

                <!-- 記事2 -->
                <article class="news-list-item" data-category="news">
                    <div class="news-list-image"
                        style="
                            background-image: url('{{ asset('images/client/top_news_open.jpg') }}');
                            background-size: cover;
                        ">
                    </div>
                    <div class="news-list-content">
                        <div class="news-list-meta">
                            <span class="news-date">2025.12.01</span>
                            <span class="news-category-tag news-tag">お知らせ</span>
                        </div>
                        <h2 class="news-list-title">2025-26シーズン営業開始</h2>
                        <p class="news-list-excerpt">
                            2025-26シーズンの営業開始日が決まりました。今シーズンも最新モデルを入荷し、万全のメンテナンスでお客様をお待ちしております。
                        </p>
                        <a href="/news/1" class="news-read-more">続きを読む →</a>
                    </div>
                </article>

                <!-- 記事3 -->
                <article class="news-list-item" data-category="blog">
                    <div class="news-list-image"
                        style="
                            background-image: url('{{ asset('images/client/top_news_stepon.jpg') }}');
                            background-size: cover;
                        ">
                    </div>
                    <div class="news-list-content">
                        <div class="news-list-meta">
                            <span class="news-date">2025.11.15</span>
                            <span class="news-category-tag blog-tag">ブログ</span>
                        </div>
                        <h2 class="news-list-title">BURTON STEP ONって何？</h2>
                        <p class="news-list-excerpt">
                            バートン最新鋭バインディングシステムステップオンはこれまでのブーツとボードを脱着するバインディングのストラップでの締め付け作業を排除
                            ブーツとバインディングをワンタッチでスピーディーに着脱する次世代システムです。
                        </p>
                        <a href="/news/3" class="news-read-more">続きを読む →</a>
                    </div>
                </article>
            </div>

            <!-- ページネーション -->
            <div class="pagination">
                <button class="pagination-btn active">1</button>
                <!-- <button class="pagination-btn">2</button> -->
                <!-- <button class="pagination-btn">3</button> -->
                <!-- <button class="pagination-btn">次へ →</button> -->
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="news-cta">
        <div class="container">
            <h2>ご予約・お問い合わせ</h2>
            <p>レンタルのご予約やご質問はお気軽にどうぞ</p>
            <div class="cta-buttons">
                <a href="https://takasuaaa.xsrv.jp/reservation/agree" class="btn-reservation">今すぐ予約する</a>
                <a href="/" class="btn-back">TOPページへ戻る</a>
            </div>
        </div>
    </section>

    <script>
        // ニュースフィルター機能
        document.addEventListener("DOMContentLoaded", () => {
            const filterBtns = document.querySelectorAll(".filter-btn");
            const newsItems = document.querySelectorAll(".news-list-item");

            filterBtns.forEach((btn) => {
                btn.addEventListener("click", () => {
                    // ボタンのアクティブ状態を切り替え
                    filterBtns.forEach((b) => b.classList.remove("active"));
                    btn.classList.add("active");

                    const category = btn.getAttribute("data-category");

                    // 記事の表示/非表示を切り替え
                    newsItems.forEach((item) => {
                        if (
                            category === "all" ||
                            item.getAttribute("data-category") === category
                        ) {
                            item.style.display = "flex";
                            setTimeout(() => {
                                item.style.opacity = "1";
                                item.style.transform = "translateY(0)";
                            }, 10);
                        } else {
                            item.style.opacity = "0";
                            item.style.transform = "translateY(20px)";
                            setTimeout(() => {
                                item.style.display = "none";
                            }, 300);
                        }
                    });
                });
            });
        });
    </script>
</x-client-layout>
