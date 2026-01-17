<?php

namespace App\Http\Controllers;

use App\Models\ERentalReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str; // ★追加: 文字列操作用

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

        public function downloadPdf($id)
        {
            // 必要な情報をロード
            $reservation = ERentalReservation::with(['details'])->findOrFail($id);

            // 印刷記録を更新
            $reservation->printed_at = now();
            $reservation->printed_user_id = Auth::id();
            $reservation->save();

        // ▼▼▼ データ整形処理を追加 ▼▼▼
        foreach ($reservation->details as $detail) {
            // 1. items_text から一番最初の "…" よりも前の文字列を取得
            $extracted = Str::before($detail->items_text, '…');

            // 全角の "…" がなくて半角の "..." だった場合の保険
            if ($extracted === $detail->items_text) {
                $extracted = Str::before($detail->items_text, '...');
            }

            $mainItemName = trim($extracted);

            // 2. 除外キーワードが含まれているかチェック (追加した処理)
            // 「グローブ」「ゴーグル」「ウェア」のいずれかが含まれていたら空文字にする
            if (Str::contains($mainItemName, ['グローブ', 'ゴーグル', 'ウェア'])) {
                $detail->main_item_name = '';
            } else {
                $detail->main_item_name = $mainItemName;
            }
        
        }
        // ▲▲▲ 追加ここまで ▲▲▲

        $pdf = Pdf::loadView('reservations.bill_for_reserve', [
                'reservation' => $reservation,
                'details'     => $reservation->details,
            ])
                ->setPaper('A4', 'portrait'); // A4縦

            $fileName = 'e_rental_reservation_'
                . ($reservation->reservation_number ?? 'unknown')
                . '_'
                . (optional($reservation->visit_date)->format('Ymd') ?? 'date')
                . '.pdf';

            return $pdf->download($fileName);
        }
}
