<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;

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
        $commentPendingReservations = Reservation::whereNotNull('note')
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
        $commentPendingReservations = Reservation::whereNotNull('note')
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
}
