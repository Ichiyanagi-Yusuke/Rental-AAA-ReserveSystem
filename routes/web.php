<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResortController;
use App\Http\Controllers\BusinessPatternController;
use App\Http\Controllers\BusinessCalendarController;
use App\Http\Controllers\RentalMenuController;
use App\Http\Controllers\GearItemController;
use App\Http\Controllers\RentalMenuComponentController;
use App\Http\Controllers\RentalMenuCategoryController;
use App\Http\Controllers\GearItemCategoryController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReservationDetailController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsPostController;
use App\Http\Controllers\PublicNewsController;


Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/home/pricing', [HomeController::class, 'pricing'])->name('client.pricing');
Route::get('/home/calendar', [HomeController::class, 'calendar'])->name('client.calendar');


Route::get('/home/news', [PublicNewsController::class, 'index'])->name('client.news.index');
Route::get('/home/news/{id}', [PublicNewsController::class, 'show'])->name('client.news.show');

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

    // 予約一覧
    Route::get('/reservations', [ReservationController::class, 'index'])
        ->name('reservations.index');

    Route::get('/reservations/create', [ReservationController::class, 'startCreate'])
        ->name('reservations.create');

    // ステップ1：ヘッダー入力
    Route::get('/reservations/create/header', [ReservationController::class, 'createHeader'])
        ->name('reservations.create.header');
    Route::post('/reservations/create/header', [ReservationController::class, 'storeHeader'])
        ->name('reservations.store.header');

    // ステップ2：詳細入力（利用者複数）
    Route::get('/reservations/create/details', [ReservationController::class, 'createDetails'])
        ->name('reservations.create.details');
    Route::post('/reservations/create/details', [ReservationController::class, 'storeDetails'])
        ->name('reservations.store.details');

    // ✅ 確認画面
    Route::get('/reservations/confirm', [ReservationController::class, 'confirm'])
        ->name('reservations.confirm');

    // ✅ 本登録（DBへ保存）
    Route::post('/reservations/store', [ReservationController::class, 'store'])
        ->name('reservations.store');

    // 利用者詳細
    Route::get('/reservations/{reservation}/details/{detail}', [ReservationDetailController::class, 'show'])
        ->name('reservations.details.show');

    // 利用者削除（詳細画面からのみ）
    Route::delete('/reservations/details/{detail}', [ReservationDetailController::class, 'destroy'])
        ->name('reservations.details.destroy');

    // ✅ 一覧画面
    Route::get('/reservations', [ReservationController::class, 'index'])
        ->name('reservations.index');

    Route::get('/reservations/{reservation}', [ReservationController::class, 'show'])
        ->name('reservations.show');

    // ★ 予約帳票PDF 1件
    Route::get('/reservations/{reservation}/pdf', [ReservationController::class, 'downloadPdf'])
        ->name('reservations.pdf');

    // ★ 貸出票印刷（フォーム表示 & 実行）
    Route::get('/reservation-prints', [ReservationController::class, 'printForm'])
        ->name('reservations.print.form');
    Route::post('/reservation-prints', [ReservationController::class, 'printExecute'])
        ->name('reservations.print.execute');

    Route::resource('news-posts', NewsPostController::class);

});

// マスタ管理用（role 0,1 のみ）
Route::middleware(['auth', 'master.role'])->group(function () {
    // create / store / edit / update / destroy がここで有効になる
    Route::resource('resorts', ResortController::class)->except(['index', 'show']);

    Route::resource('business-patterns', BusinessPatternController::class)
        ->except(['show']);

    Route::get('/business-calendars', [BusinessCalendarController::class, 'index'])
        ->name('business-calendars.index');
    Route::post('/business-calendars/update-month', [BusinessCalendarController::class, 'updateMonth'])
        ->name('business-calendars.update-month');


    Route::resource('rental-menus', RentalMenuController::class)
        ->parameters(['rental-menus' => 'rentalMenu']);

    Route::resource('gear-items', GearItemController::class)
        ->parameters(['gear-items' => 'gearItem']);

    // メニュー構成編集
    Route::get('rental-menus/{rentalMenu}/components', [RentalMenuComponentController::class, 'edit'])
        ->name('rental-menus.components.edit');

    Route::post('rental-menus/{rentalMenu}/components', [RentalMenuComponentController::class, 'update'])
        ->name('rental-menus.components.update');

    Route::resource('rental-menu-categories', RentalMenuCategoryController::class)
        ->parameters(['rental-menu-categories' => 'rentalMenuCategory']);
    // ->except(['destroy']); // destroy も使うなら except は消してOK
    Route::resource('gear-item-categories', GearItemCategoryController::class)
        ->parameters(['gear-item-categories' => 'gearItemCategory']);

});

// Resort 詳細（全ログインユーザーOK）
// ※ create より後に書くのがポイント
Route::middleware(['auth'])->group(function () {
    Route::get('/resorts/{resort}', [ResortController::class, 'show'])->name('resorts.show');
});

require __DIR__.'/auth.php';
