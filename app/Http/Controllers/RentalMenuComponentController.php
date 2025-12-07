<?php

namespace App\Http\Controllers;

use App\Models\GearItem;
use App\Models\RentalMenu;
use App\Models\RentalMenuComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentalMenuComponentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function isMasterUser(): bool
    {
        $user = Auth::user();

        return $user && in_array((int) $user->role, [0, 1], true);
    }

    /**
     * メニューごとの構成編集画面
     */
    public function edit(RentalMenu $rentalMenu)
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        // 対象メニュー
        $rentalMenu->load('category', 'components.gearItem');

        // 利用可能なギア一覧（カテゴリごと）
        $gearItems = GearItem::with('category')
            ->where('is_active', true)
            ->orderBy('gear_item_category_id')
            ->orderBy('name')
            ->get()
            ->groupBy(fn($item) => $item->category?->name ?? '未分類');

        // 既に紐づいているギアID
        $selectedGearIds = $rentalMenu->components->pluck('gear_item_id')->toArray();

        return view('rental_menus.components_edit', [
            'rentalMenu'     => $rentalMenu,
            'gearItemsGroup' => $gearItems,
            'selectedGearIds' => $selectedGearIds,
        ]);
    }

    /**
     * 構成更新処理
     */
    public function update(Request $request, RentalMenu $rentalMenu)
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        // チェックされたギアID（配列 or null）
        $gearIds = $request->input('gear_item_ids', []);

        if (! is_array($gearIds)) {
            $gearIds = [];
        }

        // 既存レコードを一度全部削除してから再登録するシンプル方式
        RentalMenuComponent::where('rental_menu_id', $rentalMenu->id)->delete();

        foreach ($gearIds as $gearId) {
            // 存在チェックは最低限
            RentalMenuComponent::create([
                'rental_menu_id' => $rentalMenu->id,
                'gear_item_id'   => (int) $gearId,
                'quantity'       => 1,      // 今は 1 固定。必要になったらフォーム側に数量入力を足す
                'is_required'    => true,   // 今はすべて必須扱い。後でオプション対応も可能
            ]);
        }

        return redirect()
            ->route('rental-menus.show', $rentalMenu)
            ->with('status', 'メニュー構成を更新しました。');
    }
}
