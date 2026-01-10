<?php

namespace App\Http\Controllers;

use App\Models\ReservationDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ReservationDetailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function isMasterUser(): bool
    {
        $user = auth()->user();

        return $user && in_array((int) $user->role, [0, 1], true);
    }

    public function show($reservationId, ReservationDetail $detail)
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        // 念のため予約との整合性チェック
        if ((int) $detail->reservation_id !== (int) $reservationId) {
            abort(404);
        }

        // リレーション読み込み
        $detail->load([
            'reservation.resort',
        ]);

        return view('reservation_details.show', [
            'detail'      => $detail,
            'reservation' => $detail->reservation,
        ]);
    }

    public function destroy(ReservationDetail $detail)
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        $reservationId = $detail->reservation_id;
        $guestName     = $detail->guest_name;

        $detail->delete();

        return redirect()
            ->route('reservations.show', $reservationId)
            ->with('status', $guestName . ' の利用者情報を削除しました。');
    }
}
