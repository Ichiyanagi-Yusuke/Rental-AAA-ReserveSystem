<x-client-layout>
    <x-slot name="seo">
        <title>RENTAL AAA（レンタルトリプルエー）| 岐阜県郡上市高鷲町 スキー・スノーボードレンタル専門店</title>
        <meta name="description" content="岐阜県郡上市高鷲町のスキー・スノーボードレンタル専門店RENTAL AAA。Burton正規取扱店で最新モデル多数。">
        {{-- 必要に応じてOGPタグなどを追加してください --}}
    </x-slot>

    <div class="loading-screen" id="loadingScreen">
        <div class="loading-content">
            <div class="loading-logo">
                <img src="{{ asset('images/client/topview-logo.png') }}" alt="RENTAL AAA">
            </div>
            <div class="loading-spinner">
                <div class="spinner-bar"></div>
                <div class="spinner-bar"></div>
                <div class="spinner-bar"></div>
            </div>
            <p class="loading-text">Loading...</p>
        </div>
    </div>

    <section id="home" class="hero">
        <div class="hero-slideshow">
            {{-- インラインスタイル内のパスも asset() を使います --}}
            <div class="hero-slide" style="background-image: url('{{ asset('images/client/top-view-1.jpg') }}');"></div>
            <div class="hero-slide" style="background-image: url('{{ asset('images/client/top-view-2.jpg') }}');"></div>
            <div class="hero-slide" style="background-image: url('{{ asset('images/client/top-view-3.jpg') }}');"></div>
            <div class="hero-slide" style="background-image: url('{{ asset('images/client/top-view-4.jpg') }}');"></div>
            <div class="hero-slide" style="background-image: url('{{ asset('images/client/top-view-5.jpg') }}');"></div>
        </div>
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <img src="{{ asset('images/client/topview-logo.png') }}" alt="RENTAL AAA" class="hero-logo-image">
        </div>

        <a href="#about" class="scroll-indicator">
            <div class="scroll-line"></div>
            <span class="scroll-text">SCROLL</span>
        </a>
    </section>

    <section id="about" class="about">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">ABOUT</h2>
                <span class="section-label">レンタルトリプルエーについて</span>
            </div>
            <div class="about-content">
                <div class="about-text">
                    <p>最高のアイテムと<br>お客様に寄り添った充実のサポート。</p>
                    <p>1997年から現在まで創業{{ date('Y') - 1997 }}年の実績。熟練のスタッフが親切かつ丁寧なサービスでお客様のスキー、スノーボードライフをしっかりとフルサポート致します！
                    </p>
                    <p>料金が同じレンタル店であっても、使用されている商材や使用時のコンディションは違ってきます。
                        トリプルエーでは、お客様に満足して頂ける様、スタッフが手作業によるホットWAX仕上げ。
                        また各アイテムの細部に至るまで、チェックとメンテナンスに時間と労力を惜しむことなく注ぎ込んでいます。</p>
                    <div class="about-features">
                        <div class="feature-item">
                            <div class="feature-image">
                                <img src="{{ asset('images/client/top_about_stepon.jpg') }}" alt="BURTON STEP ON">
                            </div>
                            <div class="feature-content">
                                <h3>BURTON STEP ON</h3>
                                <p>ワンタッチ着脱で快適な最高なスノー体験を。</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-image">
                                <img src="{{ asset('images/client/top_about_mente.jpg') }}" alt="万全のメンテナンス">
                            </div>
                            <div class="feature-content">
                                <h3>万全のメンテナンス</h3>
                                <p>熟練のスタッフが日々丁寧なメンテナンスを</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-image">
                                <img src="{{ asset('images/client/top_about_lineup.jpg') }}" alt="最新モデルも充実">
                            </div>
                            <div class="feature-content">
                                <h3>最新モデルも充実</h3>
                                <p>初心者から上級者まで満足のラインナップ</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="pricing" class="pricing">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">RENTAL PRICING</h2>
                <span class="section-label">レンタル料金</span>
            </div>
            <div class="pricing-grid">

                <div class="pricing-card">
                    <div class="pricing-header">
                        <h3>BURTON STEP ONセット</h3>
                        <div class="pricing-badge">最新</div>
                    </div>
                    <div class="pricing-body">
                        <div class="price">
                            <span class="price-amount">¥4,500</span>
                            <span class="price-period">/日</span>
                        </div>
                        <ul class="pricing-features">
                            <li>スノーボード</li>
                            <li>ブーツ</li>
                            <li>STEP ON バインディング</li>
                        </ul>
                    </div>
                </div>

                <div class="pricing-card featured">
                    <div class="pricing-header">
                        <h3>スノーボードセット</h3>
                        <div class="pricing-badge">おすすめ</div>
                    </div>
                    <div class="pricing-body">
                        <div class="price">
                            <span class="price-amount">¥3,500</span>
                            <span class="price-period">/日</span>
                        </div>
                        <ul class="pricing-features">
                            <li>スノーボード</li>
                            <li>ブーツ</li>
                            <li>バインディング調整</li>
                        </ul>
                    </div>
                </div>

                <div class="pricing-card">
                    <div class="pricing-header">
                        <h3>スキーセット</h3>
                        <div class="pricing-badge">人気</div>
                    </div>
                    <div class="pricing-body">
                        <div class="price">
                            <span class="price-amount">¥3,500</span>
                            <span class="price-period">/日</span>
                        </div>
                        <ul class="pricing-features">
                            <li>スキー板</li>
                            <li>ブーツ</li>
                            <li>ストック</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="pricing-detail-link">
                <a href="{{ route('client.pricing') }}" class="btn-pricing-detail">レンタル料金詳細はこちら</a>
            </div>
        </div>
    </section>

    <section id="access" class="access">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">ACCESS</h2>
                <span class="section-label">アクセス</span>
            </div>
            <div class="access-content">
                <div class="access-info">
                    <h3>店舗情報</h3>
                    <div class="info-item">
                        <strong>住所</strong>
                        <p>〒501-5303 岐阜県郡上市高鷲町大鷲2409-7</p>
                    </div>
                    <div class="info-item">
                        <strong>営業時間</strong>
                        <p>シーズン中は休まず営業します</p>
                        <div class="access-info-tips">
                            <p class="access-info-tips">※ シーズン初め、年末年始、シーズン終わりは営業時間が異なります。</p>
                        </div>
                        <a href="{{ route('client.calendar') }}" class="btn-calendar">営業日カレンダーを見る</a>
                    </div>
                    <div class="info-item">
                        <strong>電話番号</strong>
                        <p>0575-72-0125</p>
                    </div>
                    <div class="info-item">
                        <strong>アクセス</strong>
                        <p>・高鷲スノーパークまで車で15分<br>・ダイナランドまで車で10分<br>・鷲ヶ岳スキー場まで車で8分<br>・ひるがの高原スキー場まで車で15分</p>
                    </div>
                </div>
                <div class="access-map">
                    <div class="map-placeholder">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3229.989701587518!2d136.8770187765519!3d35.94722187250263!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6002891e696cad37%3A0xc883989ea31ddb9d!2z44Os44Oz44K_44OrQUFB!5e0!3m2!1sja!2sjp!4v1764779785377!5m2!1sja!2sjp"
                            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="news" class="news">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">NEWS & BLOG</h2>
                <span class="section-label">お知らせ＆ブログ</span>
            </div>
            <div class="news-grid">
                <a href="{{ url('/news/2') }}" class="news-card">
                    <div class="news-image"
                        style="background-image: url('{{ asset('images/client/top_news_new.jpg') }}');"></div>
                    <div class="news-content">
                        <span class="news-date">2025.12.04</span>
                        <span class="news-category">お知らせ</span>
                        <h3>Webサイトリニューアル</h3>
                        <p>レンタルトリプルエーの公式webサイトをリニューアルしました。より使いやすく、より見やすく。新しいデザインでお客様をお迎えします。お客様により快適にご利用いただけるよう、デザイン・機能・コンテンツの全てを刷新いたしました。
                        </p>
                    </div>
                </a>

                <a href="{{ url('/news/1') }}" class="news-card">
                    <div class="news-image"
                        style="background-image: url('{{ asset('images/client/top_news_open.jpg') }}');"></div>
                    <div class="news-content">
                        <span class="news-date">2025.12.01</span>
                        <span class="news-category">お知らせ</span>
                        <h3>2025-26シーズン営業開始</h3>
                        <p>2025-26シーズンの営業開始日が決まりました。今シーズンも最新モデルを入荷し、万全のメンテナンスでお客様をお待ちしております。</p>
                    </div>
                </a>

                <a href="{{ url('/news/3') }}" class="news-card">
                    <div class="news-image"
                        style="background-image: url('{{ asset('images/client/top_news_stepon.jpg') }}');"></div>
                    <div class="news-content">
                        <span class="news-date">2025.11.15</span>
                        <span class="news-category">ブログ</span>
                        <h3>BURTON STEP ONって何？</h3>
                        <p>バートン最新鋭バインディングシステムステップオンはこれまでのブーツとボードを脱着するバインディングのストラップでの締め付け作業を排除
                            ブーツとバインディングをワンタッチでスピーディーに着脱する次世代システムです。</p>
                    </div>
                </a>
            </div>
        </div>
    </section>
</x-client-layout>
