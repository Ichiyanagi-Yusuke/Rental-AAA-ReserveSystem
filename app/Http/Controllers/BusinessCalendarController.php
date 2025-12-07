<?php

namespace App\Http\Controllers;

use App\Models\BusinessCalendar;
use App\Models\BusinessPattern;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BusinessCalendarController extends Controller
{

    // $allowedMonths = [12, 1, 2, 3, 4]; で月の候補を固定
    // 実際のカレンダーの年は $displayYear で制御
    // 例：seasonYear=2025, month=12 → displayYear=2025
    // 例：seasonYear=2025, month=1 → displayYear=2026

    public function index(Request $request)
    {
        $now = now();
        $seasonYear = (int) $request->input('season_year', $now->year);

        // 12, 1, 2, 3, 4 だけ許可
        $allowedMonths = [12, 1, 2, 3, 4];

        $rawMonth = (int) $request->input('month', $now->month);
        if (!in_array($rawMonth, $allowedMonths, true)) {
            $month = 12;
        } else {
            $month = $rawMonth;
        }

        // 表示年（12月はシーズン年、それ以外はシーズン年+1）
        $displayYear = $month === 12 ? $seasonYear : $seasonYear + 1;

        $startOfMonth = \Carbon\Carbon::create($displayYear, $month, 1);
        $endOfMonth   = $startOfMonth->copy()->endOfMonth();

        $patterns = BusinessPattern::orderBy('code')->get();

        $calendars = BusinessCalendar::with('pattern')
            ->whereBetween('date', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
            ->get()
            ->keyBy(fn($item) => $item->date->toDateString());

        $weeks = [];
        $current = $startOfMonth->copy()->startOfWeek(\Carbon\Carbon::SUNDAY);
        $lastDay = $endOfMonth->copy()->endOfWeek(\Carbon\Carbon::SATURDAY);

        while ($current <= $lastDay) {
            $week = [];
            for ($i = 0; $i < 7; $i++) {
                $week[] = $current->copy();
                $current->addDay();
            }
            $weeks[] = $week;
        }

        $seasonYears = [
            $now->year - 1,
            $now->year,
            $now->year + 1,
        ];

        return view('business_calendars.index', compact(
            'seasonYear',
            'month',
            'seasonYears',
            'patterns',
            'calendars',
            'weeks',
            'displayYear',
            'allowedMonths',
        ));
    }

    public function updateMonth(Request $request)
    {
        $allowedMonths = [12, 1, 2, 3, 4];

        $rules = [
            'season_year' => ['required', 'integer'],
            'month'       => ['required', 'integer', Rule::in($allowedMonths)],
            'days'        => ['nullable', 'array'],
            'days.*.business_pattern_id' => ['nullable', 'integer', 'exists:business_patterns,id'],
        ];

        $attributes = [
            'season_year'                   => 'シーズン',
            'month'                         => '月',
            'days.*.business_pattern_id'    => '営業パターン',
        ];

        $validated = $request->validate($rules, [], $attributes);

        $seasonYear = (int) $validated['season_year'];
        $month      = (int) $validated['month'];
        $days       = $validated['days'] ?? [];

        // ★ 実際の年（12月 = シーズン年, 1〜4月 = シーズン年+1）
        $displayYear = $month === 12 ? $seasonYear : $seasonYear + 1;

        $startOfMonth = Carbon::create($displayYear, $month, 1);
        $endOfMonth   = $startOfMonth->copy()->endOfMonth();

        foreach ($days as $dateStr => $dayData) {
            $patternId = $dayData['business_pattern_id'] ?? null;

            try {
                $date = Carbon::parse($dateStr);
            } catch (\Exception $e) {
                continue;
            }

            // ★ このシーズン＆月の範囲外は無視
            if ($date->year !== $displayYear || $date->month !== $month) {
                continue;
            }

            if (!$patternId) {
                BusinessCalendar::where('date', $date->toDateString())->delete();
                continue;
            }

            BusinessCalendar::updateOrCreate(
                ['date' => $date->toDateString()],
                [
                    'business_pattern_id' => $patternId,
                    'season_year'         => $seasonYear,
                    'is_peak'             => false,
                    'memo'                => null,
                    'create_user_id'      => auth()->id(),
                    'update_user_id'      => auth()->id(),
                ]
            );
        }

        // ★ メッセージも実際の年を出す
        $messageYear = $displayYear;

        return redirect()
            ->route('business-calendars.index', [
                'season_year' => $seasonYear,
                'month'       => $month,
            ])
            ->with('status', [
                'type'    => 'success',
                'message' => "{$messageYear}年{$month}月の営業カレンダーを更新しました。",
            ]);
    }
}