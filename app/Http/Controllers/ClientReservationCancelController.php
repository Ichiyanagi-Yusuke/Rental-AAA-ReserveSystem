<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationCancelled; // 後ほど作成

class ClientReservationCancelController extends Controller
{
    /**
     * キャンセル確認画面
     */
    public function show($token)
    {
        // トークンで予約を検索（削除済みは除外される）
        $reservation = Reservation::where('token', $token)->firstOrFail();

        // 既に来店日を過ぎている場合の制御が必要ならここに追加
        // if ($reservation->visit_date < now()->toDateString()) { ... }

        return view('client.reservations.cancel.confirm', compact('reservation'));
    }

    /**
     * キャンセル実行処理
     */
    public function destroy($token)
    {
        $reservation = Reservation::where('token', $token)->firstOrFail();

        // 論理削除実行
        $reservation->delete();

        // キャンセル完了メール送信
        // try-catchで囲むのが安全ですが、開発中はエラー確認のためそのまま記述します
        Mail::to($reservation->email)->send(new ReservationCancelled($reservation));

        return view('client.reservations.cancel.complete');
    }
}
