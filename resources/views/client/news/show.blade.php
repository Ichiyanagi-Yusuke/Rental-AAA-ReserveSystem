<x-client-layout>
    <x-slot name="seo">
        <title>{{ $post->title }} | RENTAL AAA</title>
    </x-slot>

    <main class="news-detail-page">
        <div class="container">
            <article class="news-detail-article">
                <!-- パンくずリスト -->
                <nav class="breadcrumb">
                    <a href="{{ route('home') }}">HOME</a>
                    <span>/</span>
                    <a href="{{ route('client.news.index') }}">NEWS & BLOG</a>
                    <span>/</span>
                    <span>{{ $post->title }}</span>
                </nav>

                <!-- 記事ヘッダー -->
                <header class="article-header">
                    <div class="article-meta">
                        <span class="article-date">{{ $post->published_at->format('Y.m.d') }}</span>
                        @switch($post->category)
                            @case('news')
                                <span class="article-category category-news">お知らせ</span>
                            @break

                            @case('event')
                                <span class="article-category category-event">イベント</span>
                            @break

                            @case('blog')
                                <span class="article-category category-blog">ブログ</span>
                            @break

                            @default
                        @endswitch

                    </div>
                    <h1 class="article-title">{{ $post->title }}</h1>
                </header>

                <!-- 記事本文 -->
                <div class="article-content">
                    <p class="article-lead">
                        {{ $post->excerpt }}
                    </p>


                    @foreach ($post->sections as $section)
                        <section class="content-section">
                            @if ($section->heading)
                                <h2>{{ $section->heading }}</h2>
                            @endif

                            @if ($section->body)
                                <p>
                                    {!! nl2br(e($section->body)) !!}
                                </p>
                            @endif

                            @if ($section->note)
                                <p> {{ $section->note }}</p>
                            @endif
                        </section>
                    @endforeach



                    <section class="content-section">
                        <p class="article-closing">
                            {{ $post->closing_sentence }}
                        </p>
                    </section>
                </div>

                <!-- 記事フッター -->
                <footer class="article-footer">
                    <!-- <div class="share-buttons">
                        <span>この記事をシェア：</span>
                        <a href="#" class="share-btn">Twitter</a>
                        <a href="#" class="share-btn">Facebook</a>
                        <a href="#" class="share-btn">LINE</a>
                    </div> -->
                    <div class="back-to-list">
                        <a href="{{ route('client.news.index') }}" class="btn-back">一覧に戻る</a>
                    </div>
                </footer>
            </article>
        </div>
    </main>
</x-client-layout>
