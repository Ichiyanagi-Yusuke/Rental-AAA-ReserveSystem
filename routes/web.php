<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResortController;


Route::get('/', function () {
    // 未ログインなら login / ログイン済みなら dashboard
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// 参照用（全ログインユーザーOK）
Route::middleware(['auth'])->group(function () {

    // ゲレンデマスタ関連
    Route::get('resorts', [ResortController::class, 'index'])->name('resorts.index');
    Route::get('resorts', [ResortController::class, 'index'])->name('resorts.index');
   
    // マスタ一覧ページ
    Route::view('/masters', 'masters.index')->name('masters.index');
});

// マスタ管理用（role 0,1 のみ）
Route::middleware(['auth', 'master.role'])->group(function () {
    // create / store / edit / update / destroy がここで有効になる
    Route::resource('resorts', ResortController::class)->except(['index', 'show']);
});

// Resort 詳細（全ログインユーザーOK）
// ※ create より後に書くのがポイント
Route::middleware(['auth'])->group(function () {
    Route::get('/resorts/{resort}', [ResortController::class, 'show'])->name('resorts.show');
});

require __DIR__.'/auth.php';
