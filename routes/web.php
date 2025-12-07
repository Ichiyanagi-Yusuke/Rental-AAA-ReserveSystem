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
