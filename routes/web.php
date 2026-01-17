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
use App\Http\Controllers\DataAnalysisController;
use App\Http\Controllers\ClientReservationEditController;
use App\Http\Controllers\ClientReservationCancelController;
use App\Http\Controllers\DashboardController; // ★ 追加
use App\Http\Controllers\ERentalReservationController; // 追加
use App\Models\Reservation;


Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/home/pricing', [HomeController::class, 'pricing'])->name('client.pricing');
Route::get('/home/calendar', [HomeController::class, 'calendar'])->name('client.calendar');


Route::get('/home/news', [PublicNewsController::class, 'index'])->name('client.news.index');
Route::get('/home/news/{id}', [PublicNewsController::class, 'show'])->name('client.news.show');

// クライアント向け予約ページ
use App\Http\Controllers\ClientReservationController;

Route::get('/reservation/agree', [ClientReservationController::class, 'agree'])->name('client.reservation.agree');
Route::post('/reservation/agree', [ClientReservationController::class, 'storeAgree'])->name('client.reservation.agree.store');
Route::get('/reservation/header', [ClientReservationController::class, 'header'])->name('client.reservation.header');
Route::post('/reservation/header', [ClientReservationController::class, 'storeHeader'])->name('client.reservation.header.store');
Route::get('/reservation/detail', [ClientReservationController::class, 'detail'])->name('client.reservation.detail');
Route::post('/reservation/detail', [ClientReservationController::class, 'storeDetail'])->name('client.reservation.detail.store');
Route::get('/reservation/confirm', [ClientReservationController::class, 'confirm'])->name('client.reservation.confirm');
Route::post('/reservation/store', [ClientReservationController::class, 'store'])->name('client.reservation.store');
Route::get('/reservation/success', [ClientReservationController::class, 'success'])->name('client.reservation.success');
Route::get('/reservation/error', [ClientReservationController::class, 'error'])->name('client.reservation.error');

Route::get('/reservation/ss-edit-header', [ClientReservationController::class, 'editHeader'])->name('client.reservation.ss-edit.header');
Route::get('/reservation/ss-edit-detail', [ClientReservationController::class, 'editDetail'])->name('client.reservation.ss-edit.detail');

// 予約キャンセル機能
Route::prefix('reservation/cancel')->name('client.reservation.cancel.')->group(function () {
    // キャンセル確認画面 (メールのリンクからここに来る)
    Route::get('/{token}', [ClientReservationCancelController::class, 'show'])->name('show');
    // キャンセル実行
    Route::post('/{token}', [ClientReservationCancelController::class, 'destroy'])->name('destroy');
});

// ★追加する（正しい予約変更用ルート）★
Route::prefix('reservation/edit')->name('client.reservation.edit.')->group(function () {
    // 1. 本人確認（トークン付きURLから遷移）
    Route::get('/auth/{token}', [ClientReservationEditController::class, 'showAuth'])->name('auth');
    Route::post('/auth', [ClientReservationEditController::class, 'verifyAuth'])->name('auth.verify');

    // 2. 修正内容選択（メニュー）
    Route::get('/menu', [ClientReservationEditController::class, 'menu'])->name('menu');

    // 3. 代表者情報の編集
    Route::get('/header', [ClientReservationEditController::class, 'editHeader'])->name('header');
    Route::post('/header', [ClientReservationEditController::class, 'updateHeader'])->name('header.update');

    // 4. 利用者情報の編集
    Route::get('/detail/{detail}', [ClientReservationEditController::class, 'editDetail'])->name('detail');
    Route::post('/detail/{detail}', [ClientReservationEditController::class, 'updateDetail'])->name('detail.update');

    // 5. 変更完了処理
    Route::post('/complete', [ClientReservationEditController::class, 'complete'])->name('complete');
    Route::get('/finished', [ClientReservationEditController::class, 'finished'])->name('finished');
});


Route::get('/', function () {
    // 未ログインなら login / ログイン済みなら dashboard
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// メインダッシュボード
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// ★ 新規追加ページ
Route::get('/dashboard/reservations', [DashboardController::class, 'reservations'])->name('dashboard.reservations');
Route::get('/dashboard/notifications', [DashboardController::class, 'notifications'])->name('dashboard.notifications');
Route::get('/dashboard/functions', [DashboardController::class, 'functions'])->name('dashboard.functions');

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

    // 予約検索
    Route::get('/reservations-search', [ReservationController::class, 'search'])
        ->name('reservations.search');
    Route::post('/reservations-search', [ReservationController::class, 'searchResults'])
        ->name('reservations.search.results');

    // ヘッダーからの全文検索
    Route::get('/reservations-quick-search', [ReservationController::class, 'quickSearch'])
        ->name('reservations.quick-search');

    // 予約カレンダー
    Route::get('/reservations-calendar', [ReservationController::class, 'calendar'])
        ->name('reservations.calendar');

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
        ->name('reservations.show')
        ->withTrashed();

    // ★ 予約帳票PDF 1件
    Route::get('/reservations/{reservation}/pdf', [ReservationController::class, 'downloadPdf'])
        ->name('reservations.pdf');

    // ★ 貸出票印刷（フォーム表示 & 実行）
    Route::get('/reservation-prints', [ReservationController::class, 'printForm'])
        ->name('reservations.print.form');
    Route::post('/reservation-prints', [ReservationController::class, 'printExecute'])
        ->name('reservations.print.execute');

    Route::resource('news-posts', NewsPostController::class);

    // ★ 追加: データ分析関連
    Route::prefix('analysis')->name('analysis.')->group(function () {
        // 分析メニュー一覧
        Route::get('/', [DataAnalysisController::class, 'index'])->name('index');
        // 向こう1週間の予約数
        Route::get('/weekly-reservations', [DataAnalysisController::class, 'weeklyReservations'])
            ->name('weekly_reservations');

        // ▼ 追加: 今シーズンのサマリ分析
        Route::get('/season-summary', [DataAnalysisController::class, 'seasonSummary'])
            ->name('season_summary');

    });

    Route::get('/e_rental_reservations/{id}', [ERentalReservationController::class, 'show'])->name('e_rental_reservations.show');
    Route::patch('/e_rental_reservations/{id}/check_comment', [ERentalReservationController::class, 'updateCommentStatus'])->name('e_rental_reservations.check_comment');
    Route::get('/e_rental_reservations/{id}/pdf', [ERentalReservationController::class, 'downloadPdf'])->name('e_rental_reservations.pdf');

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

    Route::post('/reservations/{reservation}/verify', [ReservationController::class, 'verifyChange'])
        ->name('reservations.verify');

    // ■ キャンセル確認アクション
    Route::post('/reservations/{id}/verify-cancel', [ReservationController::class, 'verifyCancel'])
        ->name('reservations.verify_cancel');

    Route::post('/reservations/{reservation}/verify-comment', [ReservationController::class, 'verifyComment'])
        ->name('reservations.verify_comment');

    // ★ 追加: 利用者コメント確認済みアクション
    Route::post('/reservations/details/{detail}/verify-comment', [ReservationController::class, 'verifyGuestComment'])
        ->name('reservations.details.verify_comment');

});

// Resort 詳細（全ログインユーザーOK）
// ※ create より後に書くのがポイント
Route::middleware(['auth'])->group(function () {
    Route::get('/resorts/{resort}', [ResortController::class, 'show'])->name('resorts.show');
});

require __DIR__.'/auth.php';
