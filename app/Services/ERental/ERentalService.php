<?php

namespace App\Services\ERental;

use App\Models\ERentalReservation;
use App\Models\ERentalReservationDetail;
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

            // 既に同じ予約番号が存在する場合は更新、またはスキップするなどの制御が必要
            // ここではupdateOrCreateを使用
            $reservation = ERentalReservation::updateOrCreate(
                ['reservation_number' => $headerData['reservation_number']],
                $headerData
            );

            // 明細はいったん削除して作り直す（または差分更新）
            // ここでは簡易的に既存明細を削除して再登録
            $reservation->details()->delete();

            foreach ($detailsData as $detail) {
                $reservation->details()->create($detail);
            }

            Log::info("Eレンタル予約を取り込みました: {$reservation->reservation_number}");

            return $reservation;
        });
    }
}
