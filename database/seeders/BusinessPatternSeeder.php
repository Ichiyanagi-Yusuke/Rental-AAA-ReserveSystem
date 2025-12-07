<?php

namespace Database\Seeders;

use App\Models\BusinessPattern;
use App\Models\User;
use Illuminate\Database\Seeder;

class BusinessPatternSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create_user_id / update_user_id 用のユーザーIDを決定
        // 優先: role が 0 or 1 のユーザー → それが無ければ最初のユーザー → 無ければ 1
        $userId = User::whereIn('role', [0, 1])->value('id')
            ?? User::query()->value('id')
            ?? 1;

        $patterns = [
            [
                'code'        => 'HIGH_WEEKEND',
                'name'        => 'ハイシーズン休日営業',
                'description' => 'ハイシーズンの休日営業パターン。',
                'is_open'     => 1,
                'open_time'   => '02:00',
                'close_time'  => '18:30',
                'color'       => '#BA68C8',
            ],
            [
                'code'        => 'HIGH_NOMAL',
                'name'        => '通常営業',
                'description' => 'ハイシーズンの平日営業パターン。',
                'is_open'     => 1,
                'open_time'   => '05:00',
                'close_time'  => '18:00',
                'color'       => '#90CAF9',
            ],
            [
                'code'        => 'SHORTA',
                'name'        => '時短営業A',
                'description' => '時短営業。主にシーズン最初と最後の休日。',
                'is_open'     => 1,
                'open_time'   => '05:00',
                'close_time'  => '18:30',
                'color'       => '#81C784',
            ],
            [
                'code'        => 'SHORTB',
                'name'        => '時短営業B',
                'description' => '時短営業。主にシーズン最初と最後の平日。',
                'is_open'     => 1,
                'open_time'   => '06:00',
                'close_time'  => '18:00',
                'color'       => '#F97316',
            ],
            [
                'code'        => 'CLOSED',
                'name'        => '休業日',
                'description' => '完全休業日のパターン。',
                'is_open'     => 0,
                'open_time'   => null,
                'close_time'  => null,
                'color'       => '#9CA3AF',
            ],
        ];

        foreach ($patterns as $data) {
            BusinessPattern::updateOrCreate(
                ['code' => $data['code']],
                array_merge($data, [
                    'create_user_id' => $userId,
                    'update_user_id' => $userId,
                ])
            );
        }
    }
}
