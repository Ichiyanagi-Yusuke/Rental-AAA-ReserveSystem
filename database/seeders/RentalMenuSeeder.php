<?php

namespace Database\Seeders;

use App\Models\RentalMenu;
use App\Models\RentalMenuCategory;
use Illuminate\Database\Seeder;

class RentalMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // CSV「RentalMenu.csv」を展開した内容
        $menus = [
            [
                'category_name'          => 'スノーボード',
                'name'                   => 'BurtonCustomセット',
                'description'            => 'Burton Custom セット（板＋ビンディング＋ブーツ）',
                'menu_type'              => 'base',
                'is_junior'              => 0,
                'base_price'             => 9000,
                'consecutive_base_price' => 8000,
                'base_discount_amount'   => 0,
                'is_active'              => 1,
            ],
            [
                'category_name'          => 'スノーボード',
                'name'                   => 'NewModelBurtonセット',
                'description'            => 'NewModelBurtonセット（板＋ビンディング＋ブーツ）',
                'menu_type'              => 'base',
                'is_junior'              => 0,
                'base_price'             => 9000,
                'consecutive_base_price' => 8000,
                'base_discount_amount'   => 0,
                'is_active'              => 1,
            ],
            [
                'category_name'          => 'スノーボード',
                'name'                   => 'スノーボードセット',
                'description'            => '板＋ブーツ＋ビンディングのセット（大人用）',
                'menu_type'              => 'base',
                'is_junior'              => 0,
                'base_price'             => 6000,
                'consecutive_base_price' => 5000,
                'base_discount_amount'   => 0,
                'is_active'              => 1,
            ],
            [
                'category_name'          => 'スノーボード',
                'name'                   => 'Jrスノーボードセット',
                'description'            => '板＋ブーツ＋ビンディングのセット（ジュニア用）',
                'menu_type'              => 'base',
                'is_junior'              => 1,
                'base_price'             => 5000,
                'consecutive_base_price' => 4000,
                'base_discount_amount'   => 0,
                'is_active'              => 1,
            ],
            [
                'category_name'          => 'スノーボード',
                'name'                   => 'スノーボード板単品',
                'description'            => '板のみレンタル（大人用）',
                'menu_type'              => 'base',
                'is_junior'              => 0,
                'base_price'             => 4000,
                'consecutive_base_price' => 3500,
                'base_discount_amount'   => 0,
                'is_active'              => 1,
            ],
            [
                'category_name'          => 'ウェア',
                'name'                   => 'ウェアセット',
                'description'            => 'ジャケット＋パンツのセット（大人用）',
                'menu_type'              => 'option',
                'is_junior'              => 0,
                'base_price'             => 4000,
                'consecutive_base_price' => 3500,
                'base_discount_amount'   => 0,
                'is_active'              => 1,
            ],
            [
                'category_name'          => 'ウェア',
                'name'                   => 'Jrウェアセット',
                'description'            => 'ジャケット＋パンツのセット（ジュニア用）',
                'menu_type'              => 'option',
                'is_junior'              => 1,
                'base_price'             => 3500,
                'consecutive_base_price' => 3000,
                'base_discount_amount'   => 0,
                'is_active'              => 1,
            ],
            [
                'category_name'          => 'グローブ',
                'name'                   => 'グローブ',
                'description'            => '一般レンタルグローブ',
                'menu_type'              => 'option',
                'is_junior'              => 0,
                'base_price'             => 800,
                'consecutive_base_price' => 700,
                'base_discount_amount'   => 0,
                'is_active'              => 1,
            ],
            [
                'category_name'          => 'グローブ',
                'name'                   => 'ハイグレードグローブ',
                'description'            => '機能性の高いグレードアップグローブ',
                'menu_type'              => 'option',
                'is_junior'              => 0,
                'base_price'             => 1500,
                'consecutive_base_price' => 1300,
                'base_discount_amount'   => 0,
                'is_active'              => 1,
            ],
            [
                'category_name'          => 'ゴーグル',
                'name'                   => 'ゴーグル',
                'description'            => '一般レンタルゴーグル',
                'menu_type'              => 'option',
                'is_junior'              => 0,
                'base_price'             => 1000,
                'consecutive_base_price' => 900,
                'base_discount_amount'   => 0,
                'is_active'              => 1,
            ],
            [
                'category_name'          => 'ゴーグル',
                'name'                   => 'ハイグレードゴーグル',
                'description'            => '視界や曇りに強いハイグレードゴーグル',
                'menu_type'              => 'option',
                'is_junior'              => 0,
                'base_price'             => 1800,
                'consecutive_base_price' => 1600,
                'base_discount_amount'   => 0,
                'is_active'              => 1,
            ],
            [
                'category_name'          => 'スノーボード',
                'name'                   => 'Step On オプション',
                'description'            => 'Step On ビンディングへのグレードアップオプション',
                'menu_type'              => 'option',
                'is_junior'              => 0,
                'base_price'             => 2000,
                'consecutive_base_price' => 1800,
                'base_discount_amount'   => 0,
                'is_active'              => 1,
            ],
        ];

        foreach ($menus as $data) {
            // カテゴリ名からID取得
            $categoryId = RentalMenuCategory::where('name', $data['category_name'])->value('id');

            if (! $categoryId) {
                // 対応するカテゴリがない場合はスキップ
                continue;
            }

            RentalMenu::updateOrCreate(
                [
                    'rental_menu_category_id' => $categoryId,
                    'name'                    => $data['name'],
                ],
                [
                    'description'             => $data['description'] ?? null,
                    'menu_type'               => $data['menu_type'] ?? 'base',
                    'is_junior'               => (bool) ($data['is_junior'] ?? 0),
                    'base_price'              => $data['base_price'],
                    'consecutive_base_price'  => $data['consecutive_base_price'] ?? null,
                    'base_discount_amount'    => $data['base_discount_amount'] ?? 0,
                    'is_active'               => (bool) ($data['is_active'] ?? 1),
                ]
            );
        }
    }
}
