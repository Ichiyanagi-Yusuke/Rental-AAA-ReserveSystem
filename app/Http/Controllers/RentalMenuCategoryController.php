<?php

namespace App\Http\Controllers;

use App\Models\RentalMenuCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentalMenuCategoryController extends Controller
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

        $categories = RentalMenuCategory::orderBy('sort_order')
            ->orderBy('name')
            ->paginate(20);

        return view('rental_menu_categories.index', compact('categories'));
    }

    public function create()
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        return view('rental_menu_categories.create');
    }

    public function store(Request $request)
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        $validated = $request->validate([
            'name'       => ['required', 'string', 'max:100', 'unique:rental_menu_categories,name'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active'  => ['required', 'boolean'],
        ]);

        RentalMenuCategory::create($validated);

        return redirect()
            ->route('rental-menu-categories.index')
            ->with('status', 'カテゴリを登録しました。');
    }

    public function show(RentalMenuCategory $rentalMenuCategory)
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        return view('rental_menu_categories.show', compact('rentalMenuCategory'));
    }

    public function edit(RentalMenuCategory $rentalMenuCategory)
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        return view('rental_menu_categories.edit', compact('rentalMenuCategory'));
    }

    public function update(Request $request, RentalMenuCategory $rentalMenuCategory)
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        $validated = $request->validate([
            'name'       => ['required', 'string', 'max:100', 'unique:rental_menu_categories,name,' . $rentalMenuCategory->id],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active'  => ['required', 'boolean'],
        ]);

        $rentalMenuCategory->update($validated);

        return redirect()
            ->route('rental-menu-categories.index')
            ->with('status', $rentalMenuCategory->name . ' を更新しました。');
    }
    public function destroy(RentalMenuCategory $rentalMenuCategory)
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        $name = $rentalMenuCategory->name;
        $rentalMenuCategory->delete();

        return redirect()
            ->route('rental-menu-categories.index')
            ->with('status', $name . ' を削除しました。');
    }
}
