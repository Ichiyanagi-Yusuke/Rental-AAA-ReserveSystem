<?php

namespace App\Http\Controllers;

use App\Models\Resort;
use Illuminate\Http\Request;

class ResortController extends Controller
{
    /**
     * 一覧
     */
    public function index()
    {
        // ID昇順で取得
        $resorts = Resort::orderBy('id', 'asc')->get();

        return view('resorts.index', compact('resorts'));
    }

    public function show(Resort $resort)
    {
        // 作成者・更新者を一緒に読み込んでおく（定義済みのリレーション）
        $resort->load(['createUser', 'updateUser']);

        return view('resorts.show', compact('resort'));
    }

    /**
     * 新規作成フォーム
     */
    public function create()
    {
        return view('resorts.create');
    }

    /**
     * 登録処理
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:20', 'unique:resorts,name'],
            'price'         => ['required', 'integer', 'min:0'],
            'holiday_price' => ['required', 'integer', 'min:0'],
            'ticket'        => ['required', 'integer', 'min:0'],
            'sales_stop'    => ['nullable', 'boolean'],
        ]);

        $validated['sales_stop'] = $request->boolean('sales_stop');
        $validated['create_user_id'] = auth()->id();
        $validated['update_user_id'] = auth()->id();

        Resort::create($validated);

        return redirect()
            ->route('resorts.index')
            ->with('status', 'リゾートを登録しました。');
    }

    /**
     * 編集フォーム
     */
    public function edit(Resort $resort)
    {
        return view('resorts.edit', compact('resort'));
    }

    /**
     * 更新処理
     */
    public function update(Request $request, Resort $resort)
    {
        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:20', 'unique:resorts,name,' . $resort->id],
            'price'         => ['required', 'integer', 'min:0'],
            'holiday_price' => ['required', 'integer', 'min:0'],
            'ticket'        => ['required', 'integer', 'min:0'],
            'sales_stop'    => ['nullable', 'boolean'],
        ]);

        $validated['sales_stop'] = $request->boolean('sales_stop');
        $validated['update_user_id'] = auth()->id();

        $resort->update($validated);

        return redirect()
            ->route('resorts.index')
            ->with('status', 'リゾート情報を更新しました。');
    }

    /**
     * 削除（論理削除）
     */
    public function destroy(Resort $resort)
    {
        $resort->delete();

        return redirect()
            ->route('resorts.index')
            ->with('status', 'リゾートを削除しました。');
    }
}
