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
        $rules = [
            'name'          => ['required', 'string', 'max:20', 'unique:resorts,name'],
            'price'         => ['required', 'integer', 'min:0'],
            'holiday_price' => ['required', 'integer', 'min:0'],
            'ticket'        => ['required', 'integer', 'min:0'],
            'sales_stop'    => ['nullable', 'boolean'],
        ];

        // このフォーム専用の「項目名（日本語）」定義
        $attributes = [
            'name'          => 'リゾート名',
            'price'         => '通常料金',
            'holiday_price' => '休日料金',
            'ticket'        => 'チケット枚数',
            'sales_stop'    => '販売停止フラグ',
        ];

        $validated = $request->validate($rules, [], $attributes);

        $validated['sales_stop'] = $request->boolean('sales_stop');
        $validated['create_user_id'] = auth()->id();
        $validated['update_user_id'] = auth()->id();

        $resort = Resort::create($validated);

        return redirect()
            ->route('resorts.index')
            ->with('status', [
                'type'    => 'success',
                'message' => "{$resort->name}を登録しました。",
            ]);
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
        $rules = [
            'name'          => ['required', 'string', 'max:20', 'unique:resorts,name,' . $resort->id],
            'price'         => ['required', 'integer', 'min:0'],
            'holiday_price' => ['required', 'integer', 'min:0'],
            'ticket'        => ['required', 'integer', 'min:0'],
            'sales_stop'    => ['nullable', 'boolean'],
        ];

        $attributes = [
            'name'          => 'リゾート名',
            'price'         => '通常料金',
            'holiday_price' => '休日料金',
            'ticket'        => 'チケット枚数',
            'sales_stop'    => '販売停止フラグ',
        ];

        $validated = $request->validate($rules, [], $attributes);

        $validated['sales_stop'] = $request->boolean('sales_stop');
        $validated['update_user_id'] = auth()->id();

        $resort->update($validated);

        return redirect()
            ->route('resorts.index')
            ->with('status', [
                'type'    => 'success',
                'message' => "{$resort->name}を更新しました。",
            ]);
    }


    /**
     * 削除（論理削除）
     */
    public function destroy(Resort $resort)
    {
        // 削除前に名前を退避しておく
        $name = $resort->name;

        $resort->delete();

        return redirect()
            ->route('resorts.index')
            ->with('status', [
                'type'    => 'success',
                'message' => "{$name}を削除しました。",
            ]);
    }
}
