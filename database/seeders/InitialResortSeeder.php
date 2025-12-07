<?php

namespace Database\Seeders;

use App\Models\Resort;
use Illuminate\Database\Seeder;

class InitialResortSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create_user_id / update_user_id に入れるユーザーID
        // ※必要に応じて、実際の管理者ユーザーのIDに変更してください
        $adminUserId = 1;

        $resorts = [
            [
                'name'          => '高鷲スノーパーク',
                'price'         => 0,
                'holiday_price' => 0,
                'ticket'        => 0,
                'sales_stop'    => 1,
            ],
            [
                'name'          => 'ダイナランド',
                'price'         => 0,
                'holiday_price' => 0,
                'ticket'        => 0,
                'sales_stop'    => 1,
            ],
            [
                'name'          => '鷲ヶ岳スキー場',
                'price'         => 0,
                'holiday_price' => 0,
                'ticket'        => 0,
                'sales_stop'    => 1,
            ],
            [
                'name'          => 'ホワイトピア高鷲',
                'price'         => 0,
                'holiday_price' => 0,
                'ticket'        => 0,
                'sales_stop'    => 1,
            ],
            [
                'name'          => 'ひるがの高原スキー場',
                'price'         => 0,
                'holiday_price' => 0,
                'ticket'        => 0,
                'sales_stop'    => 1,
            ],
            [
                'name'          => 'スノーウェーブパーク白鳥高原',
                'price'         => 0,
                'holiday_price' => 0,
                'ticket'        => 0,
                'sales_stop'    => 1,
            ],
            [
                'name'          => 'ウイングヒルズ白鳥リゾート',
                'price'         => 0,
                'holiday_price' => 0,
                'ticket'        => 0,
                'sales_stop'    => 1,
            ],
            [
                'name'          => '郡上高原スキー場',
                'price'         => 0,
                'holiday_price' => 0,
                'ticket'        => 0,
                'sales_stop'    => 1,
            ],
        ];

        foreach ($resorts as $data) {
            Resort::updateOrCreate(
                // name をキーに重複登録を避ける
                ['name' => $data['name']],
                [
                    'price'         => $data['price'],
                    'holiday_price' => $data['holiday_price'],
                    'ticket'        => $data['ticket'],
                    'sales_stop'    => $data['sales_stop'],
                    'create_user_id' => $adminUserId,
                    'update_user_id' => $adminUserId,
                ]
            );
        }
    }
}
