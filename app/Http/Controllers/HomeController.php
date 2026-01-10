<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessCalendar;
use App\Models\BusinessPattern;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * トップページを表示する
     */
    public function index()
    {
        // ★将来的にここでデータベースからデータを取得できます
        // 例: $news = News::latest()->take(3)->get();

        // 変数をビューに渡す場合は compact('news') のように記述します
        return view('client.index');
    }

    public function calendar()
    {
        // シーズンの開始日と終了日を設定（現在のカレンダーから）
        $startDate = Carbon::parse('2025-12-01');
        $endDate = Carbon::parse('2026-04-30');

        // 指定期間のBusinessCalendarデータを取得（patternとリレーション）
        $calendars = BusinessCalendar::with('pattern')
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date')
            ->get()
            ->keyBy(function($item) {
                return $item->date->format('Y-m-d');
            });

        // 営業パターンの凡例用データを取得
        $patterns = BusinessPattern::where('is_open', true)
            ->orderBy('id')
            ->get();

        // 月ごとのカレンダーデータを生成
        $months = [];
        $currentMonth = $startDate->copy();

        while ($currentMonth->lte($endDate)) {
            $year = $currentMonth->year;
            $month = $currentMonth->month;

            // その月の1日と最終日を取得
            $firstDay = Carbon::create($year, $month, 1);
            $lastDay = $firstDay->copy()->endOfMonth();

            // 月の最初の曜日（0=日曜、6=土曜）
            $startDayOfWeek = $firstDay->dayOfWeek;

            // 日付データを格納
            $days = [];

            // 空セルを追加（月の最初の曜日まで）
            for ($i = 0; $i < $startDayOfWeek; $i++) {
                $days[] = ['empty' => true];
            }

            // 日付を追加
            for ($day = 1; $day <= $lastDay->day; $day++) {
                $date = Carbon::create($year, $month, $day);
                $dateKey = $date->format('Y-m-d');

                $calendar = $calendars->get($dateKey);

                $days[] = [
                    'day' => $day,
                    'date' => $date,
                    'calendar' => $calendar,
                    'pattern' => $calendar ? $calendar->pattern : null,
                ];
            }

            $months[] = [
                'year' => $year,
                'month' => $month,
                'days' => $days,
            ];

            $currentMonth->addMonth();
        }

        return view('client.calendar', compact('months', 'patterns'));
    }

    public function pricing()
    {
        // ★将来的にここでデータベースからデータを取得できます
        // 例: $news = News::latest()->take(3)->get();

        // 変数をビューに渡す場合は compact('news') のように記述します
        return view('client.pricing');
    }





}
