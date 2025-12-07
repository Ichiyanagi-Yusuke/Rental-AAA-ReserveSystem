<?php

namespace App\Http\Controllers;

use App\Models\BusinessPattern;
use Illuminate\Http\Request;

class BusinessPatternController extends Controller
{
    public function index()
    {
        $patterns = BusinessPattern::orderBy('code')->get();

        return view('business_patterns.index', compact('patterns'));
    }

    public function create()
    {
        return view('business_patterns.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'code'        => ['required', 'string', 'max:20', 'unique:business_patterns,code'],
            'name'        => ['required', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:255'],
            'is_open'     => ['required', 'boolean'],
            'open_time'   => ['nullable', 'date_format:H:i'],
            'close_time'  => ['nullable', 'date_format:H:i'],
            'color'       => ['nullable', 'string', 'max:7'],
        ];

        $attributes = [
            'code'        => 'コード',
            'name'        => '名称',
            'description' => '説明',
            'is_open'     => '営業区分',
            'open_time'   => '開店時間',
            'close_time'  => '閉店時間',
            'color'       => '表示色',
        ];

        $validated = $request->validate($rules, [], $attributes);

        $validated['create_user_id'] = auth()->id();
        $validated['update_user_id'] = auth()->id();

        BusinessPattern::create($validated);

        return redirect()
            ->route('business-patterns.index')
            ->with('status', [
                'type'    => 'success',
                'message' => '営業パターンを登録しました。',
            ]);
    }

    public function edit(BusinessPattern $businessPattern)
    {
        return view('business_patterns.edit', ['pattern' => $businessPattern]);
    }

    public function update(Request $request, BusinessPattern $businessPattern)
    {
        $rules = [
            'code'        => ['required', 'string', 'max:20', 'unique:business_patterns,code,' . $businessPattern->id],
            'name'        => ['required', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:255'],
            'is_open'     => ['required', 'boolean'],
            'open_time'   => ['nullable', 'date_format:H:i'],
            'close_time'  => ['nullable', 'date_format:H:i'],
            'color'       => ['nullable', 'string', 'max:7'],
        ];

        $attributes = [
            'code'        => 'コード',
            'name'        => '名称',
            'description' => '説明',
            'is_open'     => '営業区分',
            'open_time'   => '開店時間',
            'close_time'  => '閉店時間',
            'color'       => '表示色',
        ];

        $validated = $request->validate($rules, [], $attributes);

        $validated['update_user_id'] = auth()->id();

        $businessPattern->update($validated);

        return redirect()
            ->route('business-patterns.index')
            ->with('status', [
                'type'    => 'success',
                'message' => '営業パターンを更新しました。',
            ]);
    }

    public function destroy(BusinessPattern $businessPattern)
    {
        $businessPattern->delete();

        return redirect()
            ->route('business-patterns.index')
            ->with('status', [
                'type'    => 'success',
                'message' => '営業パターンを削除しました。',
            ]);
    }
}
