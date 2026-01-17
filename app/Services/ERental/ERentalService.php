<?php

namespace App\Services\ERental;

use App\Models\ERentalReservation;
use App\Models\ERentalReservationDetail;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class ERentalService
{
    public function __construct(
        private ERentalParser $parser
    ) {}

    /**
     * メール本文を受け取り、Eレンタル予約として保存する
     */
    public function importFromMailBody(string $mailBody): ERentalReservation
    {
        // 1. 解析
        $parsedData = $this->parser->parse($mailBody);

        $headerData = $parsedData['header'];
        $detailsData = $parsedData['details'];

        if (empty($headerData['reservation_number'])) {
            throw new Exception('予約番号が取得できませんでした。メールフォーマットを確認してください。');
        }

        // 2. 保存 (トランザクション)
        return DB::transaction(function () use ($headerData, $detailsData) {

            // 既存データを確認
            $reservation = ERentalReservation::where('reservation_number', $headerData['reservation_number'])->first();

            if (! $reservation) {
                // --- 新規作成の場合 ---
                // 採番を実行
                $headerData['build_number'] = $this->generateBuildNumber($headerData['visit_date']);

                $reservation = ERentalReservation::create($headerData);
            } else {
                // --- 更新の場合 ---
                // もし「来店日」が変更されていたら、採番し直す（日付単位の連番のため）
                // ※日付比較のため、フォーマットを揃えます
                $currentVisitDate = $reservation->visit_date->format('Y-m-d');
                $newVisitDate = $headerData['visit_date']; // 文字列 'YYYY-MM-DD' を想定

                if ($currentVisitDate !== $newVisitDate) {
                    $headerData['build_number'] = $this->generateBuildNumber($newVisitDate);
                }

                $reservation->update($headerData);
            }

            // 明細はいったん削除して作り直す
            $reservation->details()->delete();

            foreach ($detailsData as $detail) {
                $reservation->details()->create($detail);
            }

            Log::info("Eレンタル予約を取り込みました: {$reservation->reservation_number} (BuildNo: {$reservation->build_number})");

            return $reservation;
        });
    }

    /**
     * 指定された来店日における次の build_number を採番する
     * ReservationsテーブルとERentalReservationsテーブルの両方を見て最大値+1を返す
     */
    private function generateBuildNumber(string $visitDate): int
    {
        // 1. Web予約テーブルの最大値
        $maxWeb = Reservation::whereDate('visit_date', $visitDate)
            ->max('build_number') ?? 0;

        // 2. Eレンタル予約テーブルの最大値
        $maxExternal = ERentalReservation::whereDate('visit_date', $visitDate)
            ->max('build_number') ?? 0;

        // 大きい方に +1
        return max($maxWeb, $maxExternal) + 1;
    }
}
