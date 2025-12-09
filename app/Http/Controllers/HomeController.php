<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// 必要に応じてモデルをuseしてください
// use App\Models\News; 

class HomeController extends Controller
{
    /**
     * トップページを表示する
     */
    public function index()
    {
        // ★将来的にここでデータベースからデータを取得できます
        // 例: $news = News::latest()->take(3)->get();

        // 変数をビューに渡す場合は compact('news') のように記述します
        return view('client.index');
    }

    public function calendar()
    {
        // ★将来的にここでデータベースからデータを取得できます
        // 例: $news = News::latest()->take(3)->get();

        // 変数をビューに渡す場合は compact('news') のように記述します
        return view('client.calendar');
    }

    public function pricing()
    {
        // ★将来的にここでデータベースからデータを取得できます
        // 例: $news = News::latest()->take(3)->get();

        // 変数をビューに渡す場合は compact('news') のように記述します
        return view('client.pricing');
    }

    public function news()
    {
        // ★将来的にここでデータベースからデータを取得できます
        // 例: $news = News::latest()->take(3)->get();

        // 変数をビューに渡す場合は compact('news') のように記述します
        return view('client.news');
    }

    public function news1()
    {
        // ★将来的にここでデータベースからデータを取得できます
        // 例: $news1 = News::latest()->take(3)->get();

        // 変数をビューに渡す場合は compact('news1') のように記述します
        return view('client.news-detail-1');
    }

    public function news2()
    {
        // ★将来的にここでデータベースからデータを取得できます
        // 例: $news2 = News::latest()->take(3)->get();

        // 変数をビューに渡す場合は compact('news2') のように記述します
        return view('client.news-detail-2');
    }

    public function news3()
    {
        // ★将来的にここでデータベースからデータを取得できます
        // 例: $news3 = News3::latest()->take(3)->get();

        // 変数をビューに渡す場合は compact('news3') のように記述します
        return view('client.news-detail-3');
    }



}
