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





}
