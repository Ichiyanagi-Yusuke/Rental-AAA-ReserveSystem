<x-client-layout>
    <x-slot name="seo">
        <title>お知らせ・ブログ | RENTAL AAA</title>
        <link rel="stylesheet" href="/html/new_page/css/style.css" />
    </x-slot>

    <section class="page-header page-header-news">
        <div class="container">
            <h1>NEWS & BLOG</h1>
            <p>お知らせとブログ</p>
        </div>
    </section>

    <section class="news-filter-section">
        <div class="container">
            <div class="filter-buttons">
                <button class="filter-btn active" data-category="all">すべて</button>
                <button class="filter-btn" data-category="news">お知らせ</button>
                <button class="filter-btn" data-category="blog">ブログ</button>
                <button class="filter-btn" data-category="event">イベント</button>
            </div>
        </div>
    </section>

    <section class="news-list-section">
        <div class="container">
            <div class="news-list">
                @forelse($posts as $post)
                    <article class="news-list-item" data-category="{{ $post->category }}">
                        <div class="news-list-image"
                            style="
                                background-image: url('{{ $post->thumbnail ? asset('storage/' . $post->thumbnail) : asset('images/no-image.jpg') }}');
                                background-size: cover;
                            ">
                        </div>
                        <div class="news-list-content">
                            <div class="news-list-meta">
                                <span class="news-date">{{ $post->published_at->format('Y.m.d') }}</span>
                                <span
                                    class="news-category-tag {{ $post->category == 'news' ? 'news-tag' : 'blog-tag' }}">
                                    {{ $post->category_label }}
                                </span>
                            </div>
                            <h2 class="news-list-title">{{ $post->title }}</h2>
                            <p class="news-list-excerpt">{{ Str::limit($post->excerpt, 80) }}</p>
                            <a href="{{ route('client.news.show', $post->id) }}" class="news-read-more">続きを読む →</a>
                        </div>
                    </article>
                @empty
                    <p class="text-center w-full py-10">現在お知らせはありません。</p>
                @endforelse
            </div>

            <div class="pagination mt-8">
                {{ $posts->links('pagination::bootstrap-4') }}
                {{-- 必要に応じてカスタムページネーションビューを作成するか、スタイルを調整してください --}}
            </div>
        </div>
    </section>

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

    {{-- フィルター用スクリプトは元のまま使用 --}}
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const filterBtns = document.querySelectorAll(".filter-btn");
            const newsItems = document.querySelectorAll(".news-list-item");

            filterBtns.forEach((btn) => {
                btn.addEventListener("click", () => {
                    filterBtns.forEach((b) => b.classList.remove("active"));
                    btn.classList.add("active");
                    const category = btn.getAttribute("data-category");

                    newsItems.forEach((item) => {
                        if (category === "all" || item.getAttribute("data-category") ===
                            category) {
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
