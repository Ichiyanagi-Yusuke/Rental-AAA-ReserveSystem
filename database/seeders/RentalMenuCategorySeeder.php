<?php

namespace Database\Seeders;

use App\Models\RentalMenuCategory;
use Illuminate\Database\Seeder;

class RentalMenuCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // CSV「MenuCategory.csv」の内容をそのまま反映
        $categories = [
            [
                'name'       => 'スノーボード',
                'sort_order' => 1,
                'is_active'  => 1,
            ],
            [
                'name'       => 'スキー',
                'sort_order' => 2,
                'is_active'  => 1,
            ],
            [
                'name'       => 'ウェア',
                'sort_order' => 3,
                'is_active'  => 1,
            ],
            [
                'name'       => 'グローブ',
                'sort_order' => 4,
                'is_active'  => 1,
            ],
            [
                'name'       => 'ゴーグル',
                'sort_order' => 5,
                'is_active'  => 1,
            ],
        ];

        foreach ($categories as $data) {
            // name をキーにして upsert
            RentalMenuCategory::updateOrCreate(
                ['name' => $data['name']],
                [
                    'sort_order' => $data['sort_order'],
                    'is_active'  => (bool) $data['is_active'],
                ]
            );
        }
    }
}
