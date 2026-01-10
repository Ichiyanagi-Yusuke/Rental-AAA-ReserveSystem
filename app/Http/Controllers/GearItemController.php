<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\GearItem;
use App\Models\GearItemCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GearItemController extends Controller
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

    public function index()
    {
        $isMasterUser = $this->isMasterUser();

        $items = GearItem::with('category')
            ->orderBy('gear_item_category_id')
            ->orderBy('name')
            ->paginate(10);

        return view('gear_items.index', compact('items', 'isMasterUser'));
    }

    public function create()
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        $categories = GearItemCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('gear_items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        $validated = $request->validate([
            'gear_item_category_id'   => ['required', 'exists:gear_item_categories,id'],
            'code'                    => ['nullable', 'string', 'max:50'],
            'name'                    => ['required', 'string', 'max:100'],
            'size_label'              => ['nullable', 'string', 'max:50'],
            'brand'                   => ['nullable', 'string', 'max:50'],
            'model_name'              => ['nullable', 'string', 'max:100'],
            'is_stock_managed'        => ['required', 'boolean'],
            'stock_qty'               => ['nullable', 'integer', 'min:0'],
            'stock_warning_threshold' => ['nullable', 'integer', 'min:0'],
            'note'                    => ['nullable', 'string'],
            'is_active'               => ['required', 'boolean'],
        ]);

        // 在庫管理しない場合は在庫数関連を null に
        if (! $validated['is_stock_managed']) {
            $validated['stock_qty'] = null;
            $validated['stock_warning_threshold'] = null;
        }

        GearItem::create($validated);

        return redirect()
            ->route('gear-items.index')
            ->with('status', 'ギアを登録しました。');
    }

    public function show(GearItem $gearItem)
    {
        $isMasterUser = $this->isMasterUser();
        $gearItem->load('category');

        return view('gear_items.show', compact('gearItem', 'isMasterUser'));
    }

    public function edit(GearItem $gearItem)
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        $categories = GearItemCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('gear_items.edit', compact('gearItem', 'categories'));
    }

    public function update(Request $request, GearItem $gearItem)
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        $validated = $request->validate([
            'gear_item_category_id'   => ['required', 'exists:gear_item_categories,id'],
            'code'                    => ['nullable', 'string', 'max:50'],
            'name'                    => ['required', 'string', 'max:100'],
            'size_label'              => ['nullable', 'string', 'max:50'],
            'brand'                   => ['nullable', 'string', 'max:50'],
            'model_name'              => ['nullable', 'string', 'max:100'],
            'is_stock_managed'        => ['required', 'boolean'],
            'stock_qty'               => ['nullable', 'integer', 'min:0'],
            'stock_warning_threshold' => ['nullable', 'integer', 'min:0'],
            'note'                    => ['nullable', 'string'],
            'is_active'               => ['required', 'boolean'],
        ]);

        if (! $validated['is_stock_managed']) {
            $validated['stock_qty'] = null;
            $validated['stock_warning_threshold'] = null;
        }

        $gearItem->update($validated);

        return redirect()
            ->route('gear-items.index')
            ->with('status', $gearItem->name . ' を更新しました。');
    }

    public function destroy(GearItem $gearItem)
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        $name = $gearItem->name;
        $gearItem->delete();

        return redirect()
            ->route('gear-items.index')
            ->with('status', $name . ' を削除しました。');
    }
}
