<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\ReservationDetail;

use Illuminate\Support\Facades\DB;

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

    public function seasonSummary()
    {
        // 1. 総予約件数
        $totalReservations = Reservation::count();
        $totalGuests = ReservationDetail::count();

        // 2. 利用メニュー割合 (メインギア)
        $menuStats = ReservationDetail::select('main_gear_menu_id', DB::raw('count(*) as count'))
            ->whereNotNull('main_gear_menu_id')
            ->groupBy('main_gear_menu_id')
            ->with('mainGearMenu')
            ->get();
        $menuLabels = $menuStats->map(fn($item) => $item->mainGearMenu->name ?? '不明')->toArray();
        $menuCounts = $menuStats->pluck('count')->toArray();

        // 3. 男女比
        $genderStats = ReservationDetail::select('gender', DB::raw('count(*) as count'))
            ->whereNotNull('gender')
            ->groupBy('gender')
            ->get();
        $maleCount   = $genderStats->where('gender', 'male')->sum('count');
        $femaleCount = $genderStats->where('gender', 'female')->sum('count');
        $genderLabels = ['男性', '女性'];
        $genderData   = [$maleCount, $femaleCount];

        // 4. 子供比率
        $childStats = ReservationDetail::select('is_child', DB::raw('count(*) as count'))
            ->groupBy('is_child')
            ->get();
        $childCount = $childStats->where('is_child', 1)->sum('count');
        $adultCount = $childStats->where('is_child', 0)->sum('count');
        $childRatioLabels = ['大人', '子供'];
        $childRatioData   = [$adultCount, $childCount];

        // ★ 追加 5. ウェアサイズ割合
        // wear_size が入力されているものだけ集計
        $wearStats = ReservationDetail::select('wear_size', DB::raw('count(*) as count'))
            ->whereNotNull('wear_size')
            ->where('wear_size', '!=', '') // 空文字除外
            ->groupBy('wear_size')
            ->orderBy('wear_size') // サイズ順（文字列ソートになります）
            ->get();
        $wearSizeLabels = $wearStats->pluck('wear_size')->toArray();
        $wearSizeCounts = $wearStats->pluck('count')->toArray();

        // ★ 追加 6. 利用スキー場割合
        $resortStats = Reservation::select('resort_id', DB::raw('count(*) as count'))
            ->whereNotNull('resort_id')
            ->groupBy('resort_id')
            ->with('resort')
            ->get();
        $resortLabels = $resortStats->map(fn($item) => $item->resort->name ?? '不明')->toArray();
        $resortCounts = $resortStats->pluck('count')->toArray();

        // 7. ランキング（Top5）
        $getTop5 = function ($col, $isChild, $gender = null) {
            $query = ReservationDetail::where('is_child', $isChild);
            if (!is_null($gender)) {
                $query->where('gender', $gender);
            }
            return $query->select($col, DB::raw('count(*) as count'))
                ->whereNotNull($col)
                ->where($col, '>', 0)
                ->groupBy($col)
                ->orderByDesc('count')
                ->orderByDesc($col)
                ->limit(5)
                ->get();
        };

        $heightMen   = $getTop5('height', false, 'male');
        $footMen     = $getTop5('foot_size', false, 'male');
        $heightWomen = $getTop5('height', false, 'female');
        $footWomen   = $getTop5('foot_size', false, 'female');
        $heightKids  = $getTop5('height', true);
        $footKids    = $getTop5('foot_size', true);

        return view('data_analysis.season_summary', compact(
            'totalReservations',
            'totalGuests',
            'menuLabels',
            'menuCounts',
            'genderLabels',
            'genderData',
            'childRatioLabels',
            'childRatioData',
            'wearSizeLabels',
            'wearSizeCounts', // ★ 追加
            'resortLabels',
            'resortCounts',     // ★ 追加
            'heightMen',
            'footMen',
            'heightWomen',
            'footWomen',
            'heightKids',
            'footKids'
        ));
    }


}
