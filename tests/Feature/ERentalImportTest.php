<?php

namespace Tests\Feature;

use App\Models\ERentalReservation;
use App\Services\ERental\ERentalService;
use App\Services\ERental\ERentalParser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ERentalImportTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Eレンタルメールからの取り込みテスト
     */
    public function test_can_import_from_email_body(): void
    {
        // 1. サービスのインスタンス化
        $parser = new ERentalParser();
        $service = new ERentalService($parser);

        // 2. テスト用メール本文
        $mailBody = <<<EOD
レンタルAAA 御中 

いつもお世話になっております。
レンタル予約がありましたので、よろしくお願い致します。

----------------------------------------------------------------------
[予約番号]     1735133530
[予約受付日時] 2024年12月25日 22時41分
[申込代表者]   山田　太郎 様  （ヤマダ　タロウ）
              岐阜県関市高砂町2丁目6-43
              TEL：08088887777
              PCメールアドレス：test@icloud.com
              携帯メールアドレス：test@icloud.com
[コメント]

━━　レンタル内容　━━━━━━━━━━━━━━━
[受取予定日時] 2024年12月28日08時30分 頃 
[レンタル期間]   1 日間
[人  数] 4人
[レンタル料金 小 計] ￥20000
[消費税] 込み
[合  計] ￥20000




▼ ひびの　れな 様  [性別] 女性  [年齢] 23歳  [身長] 150cm  [足サイズ] 24.0cm  [体重] 50kg  [ボードのスタンス] レギュラー
[レンタルアイテム]
 スノーボード セット ・・・ ￥3500 
 ウェア（上下セット） ・・・ ￥3000 
[小計] ￥6500 

▼ まつだ　あお 様  [性別] 女性  [年齢] 23歳  [身長] 158cm  [足サイズ] 24.0cm  [体重] 55kg  [ボードのスタンス] レギュラー
[レンタルアイテム]
 スノーボード セット ・・・ ￥3500 
 ウェア（上下セット） ・・・ ￥3000 
[小計] ￥6500 

▼ さいとう　ももか 様  [性別] 女性  [年齢] 23歳  [身長] 165cm  [足サイズ] 24.5cm  [体重] 60kg  [ボードのスタンス] レギュラー
[レンタルアイテム]
 スノーボード セット ・・・ ￥3500 
[小計] ￥3500 

▼ みやざき　りゅういち 様  [性別] 男性  [年齢] 24歳  [身長] 185cm  [足サイズ] 27.5cm  [体重] 90kg  [ボードのスタンス] レギュラー
[レンタルアイテム]
 スノーボード セット ・・・ ￥3500 
[小計] ￥3500 

----------------------------------------------------------------------
e-レンタル http://www.e-rental.info　　（パブリックシステム株式会社）
EOD;

        // 3. 実行
        $reservation = $service->importFromMailBody($mailBody);

        // 4. 検証（アサーション）

        // DBに保存されているか確認
        // 日付(visit_date)は環境差異でエラーになりやすいため、ここには含めず個別にチェックします
        $this->assertDatabaseHas('e_rental_reservations', [
            'reservation_number' => '1735133530',
            'rep_name'           => '山田　太郎',
            'rep_kana'           => 'ヤマダ　タロウ',
            'phone'              => '08088887777',
            'email_pc'           => 'test@icloud.com',
            'number_of_people'   => 4,
            'total_price'        => 20000,
        ]);

        // 日付の個別チェック (フォーマットを揃えて比較)
        // モデルで casts = ['visit_date' => 'date'] が設定されていれば Carbonインスタンス になっています
        $this->assertEquals('2024-12-28', $reservation->visit_date->format('Y-m-d'));

        // 明細が4件保存されているか確認
        $this->assertCount(4, $reservation->details);

        // 1人目の明細チェック
        $this->assertDatabaseHas('e_rental_reservation_details', [
            'e_rental_reservation_id' => $reservation->id,
            'guest_name' => 'ひびの　れな',
            'height'     => 150,
            'foot_size'  => 24.0,
            'gender'     => '女性',
        ]);

        // 4人目の明細チェック
        $this->assertDatabaseHas('e_rental_reservation_details', [
            'e_rental_reservation_id' => $reservation->id,
            'guest_name' => 'みやざき　りゅういち',
            'height'     => 185,
        ]);
    }
}
