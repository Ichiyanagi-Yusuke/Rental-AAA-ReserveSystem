<?php

namespace Database\Seeders;

use App\Models\GearItemCategory;
use Illuminate\Database\Seeder;

class GearItemCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'code'       => 'SNOWBOARD',
                'name'       => 'スノーボード',
                'sort_order' => 1,
                'is_active'  => 1,
            ],
            [
                'code'       => 'BINDING',
                'name'       => 'ビンディング',
                'sort_order' => 2,
                'is_active'  => 1,
            ],
            [
                'code'       => 'SNOWBOARDBOOT',
                'name'       => 'スノーボードブーツ',
                'sort_order' => 3,
                'is_active'  => 1,
            ],
            [
                'code'       => 'SKI',
                'name'       => 'スキー板',
                'sort_order' => 4,
                'is_active'  => 1,
            ],
            [
                'code'       => 'SKIBOOT',
                'name'       => 'スキーブーツ',
                'sort_order' => 5,
                'is_active'  => 1,
            ],
            [
                'code'       => 'STOCK',
                'name'       => 'ストック',
                'sort_order' => 6,
                'is_active'  => 1,
            ],
            [
                'code'       => 'WEAR',
                'name'       => 'ウェア',
                'sort_order' => 7,
                'is_active'  => 1,
            ],
            [
                'code'       => 'GLOVE',
                'name'       => 'グローブ',
                'sort_order' => 8,
                'is_active'  => 1,
            ],
            [
                'code'       => 'GOGGLE',
                'name'       => 'ゴーグル',
                'sort_order' => 9,
                'is_active'  => 1,
            ],
            [
                'code'       => 'ACCESSORY',
                'name'       => 'アクセサリ',
                'sort_order' => 10,
                'is_active'  => 1,
            ],
        ];

        foreach ($categories as $data) {
            GearItemCategory::updateOrCreate(
                ['code' => $data['code']], // code をキーに upsert
                [
                    'name'       => $data['name'],
                    'sort_order' => (int) $data['sort_order'],
                    'is_active'  => (bool) $data['is_active'],
                ]
            );
        }
    }
}
