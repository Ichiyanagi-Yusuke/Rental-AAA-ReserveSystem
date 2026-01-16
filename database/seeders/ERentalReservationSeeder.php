<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ERentalReservation;
use App\Models\ERentalReservationDetail;
use Carbon\Carbon;

class ERentalReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 既存のデータをクリア（重複エラー防止のため）
        // ERentalReservationDetailはCascade削除される設定なら親の削除だけで消えますが、念のため
        ERentalReservation::query()->delete();

        // ---------------------------------------------------------
        // データ1: メール文面の例（山田 太郎）
        // ---------------------------------------------------------
        $reservation1 = ERentalReservation::create([
            'reservation_number' => '1735133530',
            'reception_at'       => Carbon::create(2024, 12, 25, 22, 41),
            'rep_name'           => '山田　太郎',
            'rep_kana'           => 'ヤマダ　タロウ',
            'address'            => '岐阜県関市高砂町2丁目6-43',
            'phone'              => '08088887777',
            'email_pc'           => 'test@icloud.com',
            'email_mobile'       => 'test@icloud.com',
            'visit_date'         => '2024-12-28',
            'visit_time'         => '08:30:00',
            'rental_days'        => 1,
            'number_of_people'   => 4,
            'total_price'        => 20000,
            'comment'            => '',
            'import_status'      => 0, // 未反映
        ]);

        // 明細1-1
        $reservation1->details()->create([
            'guest_name'     => 'ひびの　れな',
            'gender'         => '女性',
            'age'            => 23,
            'height'         => 150,
            'foot_size'      => 24.0,
            'weight'         => 50,
            'stance'         => 'レギュラー',
            'items_text'     => "スノーボード セット ・・・ ￥3500\nウェア（上下セット） ・・・ ￥3000",
            'subtotal_price' => 6500,
        ]);

        // 明細1-2
        $reservation1->details()->create([
            'guest_name'     => 'まつだ　あお',
            'gender'         => '女性',
            'age'            => 23,
            'height'         => 158,
            'foot_size'      => 24.0,
            'weight'         => 55,
            'stance'         => 'レギュラー',
            'items_text'     => "スノーボード セット ・・・ ￥3500\nウェア（上下セット） ・・・ ￥3000",
            'subtotal_price' => 6500,
        ]);

        // 明細1-3
        $reservation1->details()->create([
            'guest_name'     => 'さいとう　ももか',
            'gender'         => '女性',
            'age'            => 23,
            'height'         => 165,
            'foot_size'      => 24.5,
            'weight'         => 60,
            'stance'         => 'レギュラー',
            'items_text'     => "スノーボード セット ・・・ ￥3500",
            'subtotal_price' => 3500,
        ]);

        // 明細1-4
        $reservation1->details()->create([
            'guest_name'     => 'みやざき　りゅういち',
            'gender'         => '男性',
            'age'            => 24,
            'height'         => 185,
            'foot_size'      => 27.5,
            'weight'         => 90,
            'stance'         => 'レギュラー',
            'items_text'     => "スノーボード セット ・・・ ￥3500",
            'subtotal_price' => 3500,
        ]);


        // ---------------------------------------------------------
        // データ2: 別の日付の例（鈴木 花子）
        // ---------------------------------------------------------
        $reservation2 = ERentalReservation::create([
            'reservation_number' => '1735133999',
            'reception_at'       => Carbon::create(2024, 12, 26, 10, 00),
            'rep_name'           => '鈴木　花子',
            'rep_kana'           => 'スズキ　ハナコ',
            'address'            => '愛知県名古屋市中村区1-1-1',
            'phone'              => '09012345678',
            'email_pc'           => 'hanako@example.com',
            'email_mobile'       => null,
            'visit_date'         => '2024-12-29', // 山田さんの翌日
            'visit_time'         => '09:00:00',
            'rental_days'        => 2,
            'number_of_people'   => 1,
            'total_price'        => 8000,
            'comment'            => '初心者です。よろしくお願いします。',
            'import_status'      => 0, // 未反映
        ]);

        // 明細2-1
        $reservation2->details()->create([
            'guest_name'     => '鈴木　花子',
            'gender'         => '女性',
            'age'            => 28,
            'height'         => 160,
            'foot_size'      => 23.5,
            'weight'         => 52,
            'stance'         => 'グーフィー',
            'items_text'     => "スキーセット ・・・ ￥4000\n（2日間）",
            'subtotal_price' => 8000,
        ]);
    }
}
