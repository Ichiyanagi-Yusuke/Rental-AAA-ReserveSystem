<?php

namespace App\Http\Controllers;

use App\Models\NewsPost;
use Illuminate\Http\Request;

class PublicNewsController extends Controller
{
    public function index()
    {
        $posts = NewsPost::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->paginate(9); // 1ページ9件

        return view('client.news.index', compact('posts'));
    }

    public function show($id)
    {
        $post = NewsPost::where('is_published', true)->findOrFail($id);

        // 前後の記事を取得（ナビゲーション用）
        $prev = NewsPost::where('is_published', true)
            ->where('published_at', '<', $post->published_at)
            ->orderBy('published_at', 'desc')
            ->first();

        $next = NewsPost::where('is_published', true)
            ->where('published_at', '>', $post->published_at)
            ->orderBy('published_at', 'asc')
            ->first();

        return view('client.news.show', compact('post', 'prev', 'next'));
    }
}
