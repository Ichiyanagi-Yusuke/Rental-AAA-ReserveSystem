<?php

namespace App\Http\Controllers;

use App\Models\ERentalReservation;
use Illuminate\Http\Request;

class ERentalReservationController extends Controller
{
    public function show($id)
    {
        // 紐付く明細も一緒に取得
        $reservation = ERentalReservation::with('details')->findOrFail($id);

        return view('e_rental_reservations.show', compact('reservation'));
    }

    public function updateCommentStatus(Request $request, $id)
    {
        $reservation = ERentalReservation::findOrFail($id);

        // ステータスを反転、またはtrueにする
        // ここではシンプルに「未確認なら確認済みに、確認済みなら未確認に戻す」トグル仕様にします
        $reservation->is_comment_checked = ! $reservation->is_comment_checked;
        $reservation->save();

        $message = $reservation->is_comment_checked ? 'コメントを確認済みにしました。' : 'コメントを未確認に戻しました。';

        return back()->with('status', $message);
    }
}
