<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RentalMenu;
use App\Models\RentalMenuCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentalMenuController extends Controller
{
    public function __construct()
    {
        // ログイン必須
        $this->middleware('auth');
    }

    /**
     * マスタ権限を持つユーザーかどうか
     */
    private function isMasterUser(): bool
    {
        $user = Auth::user();

        return $user && in_array((int) $user->role, [0, 1], true);
    }

    /**
     * 一覧表示（一般ユーザーも参照OK）
     */
    public function index()
    {
        $user = Auth::user();
        $isMasterUser = $this->isMasterUser();

        $menus = RentalMenu::with('category')
            ->orderBy('rental_menu_category_id')
            ->orderBy('is_junior')
            ->orderBy('name')
            ->paginate(10);

        return view('rental_menus.index', compact('menus', 'user', 'isMasterUser'));
    }

    /**
     * 新規作成画面（マスタユーザーのみ）
     */
    public function create()
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        $categories = RentalMenuCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $menuTypes = [
            'base'   => 'メインメニュー',
            'option' => 'オプション',
        ];

        return view('rental_menus.create', compact('categories', 'menuTypes'));
    }

    /**
     * 新規登録処理
     */
    public function store(Request $request)
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        $validated = $request->validate([
            'rental_menu_category_id' => ['required', 'exists:rental_menu_categories,id'],
            'name'                    => ['required', 'string', 'max:100'],
            'description'             => ['nullable', 'string'],
            'menu_type'               => ['required', 'in:base,option'],
            'is_junior'               => ['required', 'boolean'],
            'base_price'              => ['required', 'integer', 'min:0'],
            'consecutive_base_price'  => ['nullable', 'integer', 'min:0'],
            'base_discount_amount'    => ['required', 'integer', 'min:0'],
            'is_active'               => ['required', 'boolean'],
        ]);

        RentalMenu::create($validated);

        return redirect()
            ->route('rental-menus.index')
            ->with('status', 'レンタルメニューを登録しました。');
    }

    /**
     * 詳細表示（必要なら）
     */
    public function show(RentalMenu $rentalMenu)
    {
        $user = Auth::user();
        $isMasterUser = $this->isMasterUser();

        // カテゴリ + 構成ギアをまとめてロード
        $rentalMenu->load([
            'category',
            'components.gearItem.category', // gearItem とそのカテゴリまで
        ]);

        return view('rental_menus.show', compact('rentalMenu', 'user', 'isMasterUser'));
    }

    /**
     * 編集画面（マスタユーザーのみ）
     */
    public function edit(RentalMenu $rentalMenu)
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        $categories = RentalMenuCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $menuTypes = [
            'base'   => 'メインメニュー',
            'option' => 'オプション',
        ];

        return view('rental_menus.edit', compact('rentalMenu', 'categories', 'menuTypes'));
    }

    /**
     * 更新処理
     */
    public function update(Request $request, RentalMenu $rentalMenu)
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        $validated = $request->validate([
            'rental_menu_category_id' => ['required', 'exists:rental_menu_categories,id'],
            'name'                    => ['required', 'string', 'max:100'],
            'description'             => ['nullable', 'string'],
            'menu_type'               => ['required', 'in:base,option'],
            'is_junior'               => ['required', 'boolean'],
            'base_price'              => ['required', 'integer', 'min:0'],
            'consecutive_base_price'  => ['nullable', 'integer', 'min:0'],
            'base_discount_amount'    => ['required', 'integer', 'min:0'],
            'is_active'               => ['required', 'boolean'],
        ]);

        $rentalMenu->update($validated);

        return redirect()
            ->route('rental-menus.index')
            ->with('status', $rentalMenu->name . ' を更新しました。');
    }

    /**
     * 削除処理（ソフトデリート）
     */
    public function destroy(RentalMenu $rentalMenu)
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        $name = $rentalMenu->name;
        $rentalMenu->delete();

        return redirect()
            ->route('rental-menus.index')
            ->with('status', $name . ' を削除しました。');
    }
}
