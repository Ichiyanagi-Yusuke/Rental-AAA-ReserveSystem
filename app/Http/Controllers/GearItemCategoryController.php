<?php

namespace App\Http\Controllers;

use App\Models\GearItemCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GearItemCategoryController extends Controller
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
        if (! $this->isMasterUser()) {
            abort(403);
        }

        $categories = GearItemCategory::orderBy('sort_order')
            ->orderBy('name')
            ->paginate(20);

        return view('gear_item_categories.index', compact('categories'));
    }

    public function create()
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        return view('gear_item_categories.create');
    }

    public function store(Request $request)
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        $validated = $request->validate([
            'code'       => ['nullable', 'string', 'max:50', 'unique:gear_item_categories,code'],
            'name'       => ['required', 'string', 'max:100'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active'  => ['required', 'boolean'],
        ]);

        GearItemCategory::create($validated);

        return redirect()
            ->route('gear-item-categories.index')
            ->with('status', 'ギアカテゴリを登録しました。');
    }

    public function show(GearItemCategory $gearItemCategory)
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        return view('gear_item_categories.show', compact('gearItemCategory'));
    }

    public function edit(GearItemCategory $gearItemCategory)
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        return view('gear_item_categories.edit', compact('gearItemCategory'));
    }

    public function update(Request $request, GearItemCategory $gearItemCategory)
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        $validated = $request->validate([
            'code'       => ['nullable', 'string', 'max:50', 'unique:gear_item_categories,code,' . $gearItemCategory->id],
            'name'       => ['required', 'string', 'max:100'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active'  => ['required', 'boolean'],
        ]);

        $gearItemCategory->update($validated);

        return redirect()
            ->route('gear-item-categories.index')
            ->with('status', $gearItemCategory->name . ' を更新しました。');
    }

    public function destroy(GearItemCategory $gearItemCategory)
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        $name = $gearItemCategory->name;
        $gearItemCategory->delete();

        return redirect()
            ->route('gear-item-categories.index')
            ->with('status', $name . ' を削除しました。');
    }
}
