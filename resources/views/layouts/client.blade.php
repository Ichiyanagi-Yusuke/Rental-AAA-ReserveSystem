<!DOCTYPE html>
<html lang="ja" prefix="og: http://ogp.me/ns#">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- SEO情報 --}}
    @if (isset($seo))
        {{ $seo }}
    @else
        <title>RENTAL AAA</title>
    @endif

    <link rel="canonical" href="{{ url()->current() }}">

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;700;900&family=Oswald:wght@400;700&display=swap"
        rel="stylesheet">
</head>

<body>
    {{-- ★ここにあったローディング画面のHTMLを削除しました★ --}}

    <nav class="navbar">
        <div class="nav-container">
            <a href="{{ route('home') }}" class="logo">
                <img src="{{ asset('images/client/header-logo.png') }}" alt="RENTAL AAA" class="logo-image">
            </a>
            <button class="hamburger" id="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </nav>

    <div class="side-menu" id="sideMenu">
        <div class="side-menu-close" id="closeMenu">×</div>
        <ul class="side-menu-list">
            <li><a href="{{ route('home') }}#about" class="side-menu-link"><span class="menu-main">ABOUT</span><span
                        class="menu-sub">レンタルトリプルエーについて</span></a></li>
            <li><a href="{{ route('client.pricing') }}" class="side-menu-link"><span class="menu-main">RENTAL
                        PRICE</span><span class="menu-sub">レンタル料金詳細</span></a></li>
            <li><a href="{{ route('home') }}#access" class="side-menu-link"><span class="menu-main">ACCESS</span><span
                        class="menu-sub">アクセス/マップ</span></a></li>
            <li><a href="{{ route('client.calendar') }}" class="side-menu-link"><span class="menu-main">OPEN
                        CALENDAR</span><span class="menu-sub">営業日カレンダー</span></a></li>
            <li><a href="{{ url('/news') }}" class="side-menu-link"><span class="menu-main">NEWS & BLOG</span><span
                        class="menu-sub">お知らせ/ブログ</span></a></li>
        </ul>
        <div class="side-menu-reservation">
            <a href="https://takasuaaa.xsrv.jp/reservation/agree" class="btn-side-reservation">予約する</a>
        </div>
    </div>

    <div class="overlay" id="overlay"></div>

    {{-- メインコンテンツ --}}
    <main>
        {{ $slot }}
    </main>

    <section class="cta-section">
        <div class="container">
            <h2>今すぐ予約して、<br>最高のスノーシーズンを。</h2>
            <a href="https://takasuaaa.xsrv.jp/reservation/agree" class="btn-reservation">オンライン予約</a>
        </div>
    </section>

    <a href="https://takasuaaa.xsrv.jp/reservation/agree" class="btn-floating-reservation" id="floatingReservation">
        <span class="btn-floating-icon">
            <img src="{{ asset('images/client/reserve-icon.svg') }}" alt="予約アイコン">
        </span>
        <div class="btn-floating-content">
            <span class="btn-floating-main">RESERVE</span>
            <span class="btn-floating-sub">予約する</span>
        </div>
    </a>

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-info">
                    <h3>
                        <img src="{{ asset('images/client/header-logo.png') }}" alt="RENTAL AAA"
                            class="footer-logo-image">
                    </h3>
                    <p>〒501-5303 岐阜県郡上市高鷲町大鷲2409-7</p>
                    <p>TEL: 0575-72-0125</p>
                    <p>基本営業時間: 平日 5:00 - 18:00 休日 2:00 - 18:30</p>
                    <p>※ 詳細は<a href="{{ route('client.calendar') }}">営業カレンダー</a>をご確認ください。</p>
                </div>
                <div class="footer-links">
                    <h4>メニュー</h4>
                    <ul>
                        <li><a href="{{ route('home') }}#about">ABOUT</a></li>
                        <li><a href="{{ route('client.pricing') }}">RENTAL PRICE</a></li>
                        <li><a href="{{ route('home') }}#access">ACCESS</a></li>
                        <li><a href="{{ url('/news') }}">NEWS & BLOG</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>© 2025-{{ date('Y') + 1 }} RENTAL AAA. All rights reserved.</p>
            </div>
        </div>
    </footer>

    {{-- JS --}}
    <script src="{{ asset('js/landing.js') }}"></script>


</body>

</html>
