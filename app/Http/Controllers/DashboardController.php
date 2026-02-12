<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\ReservationSummary;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * メインダッシュボード（マスタ管理など）
     */
    public function index()
    {
        // 変更確認待ち
        $modifiedReservations = Reservation::where('is_needs_confirmation', true)
            ->orderBy('updated_at', 'desc')
            ->get();

        // キャンセル回収待ち
        $cancelledReservations = Reservation::onlyTrashed()
            ->where('is_cancel_needs_confirmation', true)
            ->orderBy('deleted_at', 'desc')
            ->get();

        // 代表者コメント確認待ち
        // $commentPendingReservations = Reservation::whereNotNull('note')
        //     ->where('note', '!=', '')
        //     ->where('is_comment_checked', false)
        //     ->orderBy('visit_date', 'asc')
        //     ->get();

        $commentPendingReservations = ReservationSummary::whereNotNull('note')
            ->where('note', '!=', '')
            ->where('is_comment_checked', false)
            ->orderBy('visit_date', 'asc')
            ->get();

        // 利用者コメント確認待ち
        $guestCommentPendingReservations = Reservation::whereHas('details', function ($query) {
            $query->whereNotNull('note')
                ->where('note', '!=', '')
                ->where('is_comment_checked', false);
        })
            ->orderBy('visit_date', 'asc')
            ->get();

        return view('dashboard',
            compact(
                'modifiedReservations',
                'cancelledReservations',
                'commentPendingReservations',
                'guestCommentPendingReservations'));
    }

    /**
     * 予約メニュー（予約管理、本日・明日の予約）
     */
    public function reservations()
    {
        return view('dashboard.reservations');
    }

    /**
     * 通知メニュー（変更、キャンセル、コメント確認）
     */
    public function notifications()
    {
        // 変更確認待ち
        $modifiedReservations = Reservation::where('is_needs_confirmation', true)
            ->orderBy('updated_at', 'desc')
            ->get();

        // キャンセル回収待ち
        $cancelledReservations = Reservation::onlyTrashed()
            ->where('is_cancel_needs_confirmation', true)
            ->orderBy('deleted_at', 'desc')
            ->get();

        // 代表者コメント確認待ち
        // $commentPendingReservations = Reservation::whereNotNull('note')
        //     ->where('note', '!=', '')
        //     ->where('is_comment_checked', false)
        //     ->orderBy('visit_date', 'asc')
        //     ->get();

        $commentPendingReservations = ReservationSummary::whereNotNull('note')
            ->where('note', '!=', '')
            ->where('is_comment_checked', false)
            ->orderBy('visit_date', 'asc')
            ->get();

        // 利用者コメント確認待ち
        $guestCommentPendingReservations = Reservation::whereHas('details', function ($query) {
            $query->whereNotNull('note')
                ->where('note', '!=', '')
                ->where('is_comment_checked', false);
        })
            ->orderBy('visit_date', 'asc')
            ->get();

        return view('dashboard.notifications', compact(
            'modifiedReservations',
            'cancelledReservations',
            'commentPendingReservations',
            'guestCommentPendingReservations'
        ));
    }

    /**
     * 機能メニュー（印刷、分析、ブログ）
     */
    public function functions()
    {
        return view('dashboard.functions');
    }

    /**
     * 予約回数実績（過去4週間の日別予約登録件数）
     */
    public function reservationStats()
    {
        // 過去4週間（28日間）の範囲を計算
        $endDate = Carbon::today();
        $startDate = Carbon::today()->subDays(27); // 今日を含めて28日間

        // 日別の予約登録件数を取得（created_atを基準）
        $stats = Reservation::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->whereBetween(DB::raw('DATE(created_at)'), [$startDate->toDateString(), $endDate->toDateString()])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date', 'desc')
            ->get()
            ->keyBy('date');

        // テーブルデータとグラフデータを生成
        $tableData = [];
        $chartLabels = [];
        $chartData = [];
        $totalCount = 0;

        // 過去28日分のデータを生成（降順：新しい日付から）
        for ($i = 0; $i < 28; $i++) {
            $date = Carbon::today()->subDays($i);
            $dateStr = $date->toDateString();
            $count = $stats->has($dateStr) ? $stats[$dateStr]->count : 0;
            $totalCount += $count;

            $tableData[] = [
                'date' => $dateStr,
                'displayDate' => $date->format('n/j') . '(' . ['日', '月', '火', '水', '木', '金', '土'][$date->dayOfWeek] . ')',
                'count' => $count,
            ];
        }

        // グラフ用データは昇順（古い日付から）
        $chartTableData = array_reverse($tableData);
        foreach ($chartTableData as $data) {
            $chartLabels[] = $data['displayDate'];
            $chartData[] = $data['count'];
        }

        return view('dashboard.reservation_stats', compact(
            'tableData',
            'chartLabels',
            'chartData',
            'totalCount'
        ));
    }
}
