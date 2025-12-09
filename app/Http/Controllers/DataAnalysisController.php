<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DataAnalysisController extends Controller
{
    // マスタ権限チェック（Middlewareで制御する場合はコンストラクタで不要ですが、念のため）
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            if (! $user || ! in_array((int) $user->role, [0, 1], true)) {
                abort(403);
            }
            return $next($request);
        });
    }

    /**
     * データ分析メニュー（マスタ一覧のような中間ページ）
     */
    public function index()
    {
        return view('data_analysis.index');
    }

    /**
     * 向こう1週間の予約件数（グラフ＆テーブル）
     */
    public function weeklyReservations()
    {
        // 今日から向こう7日間（今日含む）
        $startDate = Carbon::today();
        $days = 7;

        // 日付ごとの予約数を取得
        // 日付をキーにしてカウントを取得 (例: ['2025-12-10' => 5, '2025-12-12' => 3])
        $reservations = Reservation::whereDate('visit_date', '>=', $startDate)
            ->whereDate('visit_date', '<', $startDate->copy()->addDays($days))
            ->selectRaw('DATE(visit_date) as date, count(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');

        // グラフとテーブル用にデータを整形（予約がない日も0件として埋める）
        $chartLabels = [];
        $chartData   = [];
        $tableData   = [];

        for ($i = 0; $i < $days; $i++) {
            $date = $startDate->copy()->addDays($i);
            $dateString = $date->toDateString();

            // 予約数取得（なければ0）
            $count = $reservations[$dateString] ?? 0;

            // グラフ用ラベル (例: 12/10(水))
            $chartLabels[] = $date->format('m/d') . '(' . $date->isoFormat('ddd') . ')';
            $chartData[]   = $count;

            // テーブル用データ
            $tableData[] = [
                'date'        => $dateString,
                'displayDate' => $date->format('Y年m月d日') . '(' . $date->isoFormat('ddd') . ')',
                'count'       => $count,
            ];
        }

        return view('data_analysis.weekly_reservations', compact('chartLabels', 'chartData', 'tableData'));
    }
}
