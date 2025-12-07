<?php

namespace Database\Seeders;

use App\Models\GearItem;
use App\Models\GearItemCategory;
use Illuminate\Database\Seeder;

class GearItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // CSVサンプルの内容を配列化したもの
        $items = [
            [
                'category_code'           => 'SNOWBOARD',
                'code'                    => 'STD_BOARD_150',
                'name'                    => 'スタンダードボード 150cm',
                'size_label'              => '150cm',
                'brand'                   => '汎用',
                'model_name'              => '',
                'is_stock_managed'        => 1,
                'stock_qty'               => 10,
                'stock_warning_threshold' => 2,
                'note'                    => '',
                'is_active'               => 1,
            ],
            [
                'category_code'           => 'SNOWBOARD',
                'code'                    => 'STD_BOARD_155',
                'name'                    => 'スタンダードボード 155cm',
                'size_label'              => '155cm',
                'brand'                   => '汎用',
                'model_name'              => '',
                'is_stock_managed'        => 1,
                'stock_qty'               => 8,
                'stock_warning_threshold' => 2,
                'note'                    => '',
                'is_active'               => 1,
            ],
            [
                'category_code'           => 'SNOWBOARD',
                'code'                    => 'BURTON_CUSTOM_154',
                'name'                    => 'Burton Custom 154',
                'size_label'              => '154cm',
                'brand'                   => 'Burton',
                'model_name'              => 'Custom',
                'is_stock_managed'        => 1,
                'stock_qty'               => 5,
                'stock_warning_threshold' => 1,
                'note'                    => 'ハイグレードボード',
                'is_active'               => 1,
            ],
            [
                'category_code'           => 'SNOWBOARDBOOT',
                'code'                    => 'STD_BOOT_26',
                'name'                    => 'スタンダードブーツ 26.0cm',
                'size_label'              => '26.0',
                'brand'                   => '汎用',
                'model_name'              => '',
                'is_stock_managed'        => 1,
                'stock_qty'               => 12,
                'stock_warning_threshold' => 3,
                'note'                    => '',
                'is_active'               => 1,
            ],
            [
                'category_code'           => 'SNOWBOARDBOOT',
                'code'                    => 'STD_BOOT_27',
                'name'                    => 'スタンダードブーツ 27.0cm',
                'size_label'              => '27.0',
                'brand'                   => '汎用',
                'model_name'              => '',
                'is_stock_managed'        => 1,
                'stock_qty'               => 10,
                'stock_warning_threshold' => 3,
                'note'                    => '',
                'is_active'               => 1,
            ],
            [
                'category_code'           => 'SNOWBOARDBOOT',
                'code'                    => 'BURTON_BOOT_27',
                'name'                    => 'Burton ブーツ 27.0cm',
                'size_label'              => '27.0',
                'brand'                   => 'Burton',
                'model_name'              => '',
                'is_stock_managed'        => 1,
                'stock_qty'               => 4,
                'stock_warning_threshold' => 1,
                'note'                    => 'Custom セット用',
                'is_active'               => 1,
            ],
            [
                'category_code'           => 'BINDING',
                'code'                    => 'STD_BINDING_M',
                'name'                    => 'スタンダードビンディング M',
                'size_label'              => 'M',
                'brand'                   => '汎用',
                'model_name'              => '',
                'is_stock_managed'        => 1,
                'stock_qty'               => 10,
                'stock_warning_threshold' => 2,
                'note'                    => '',
                'is_active'               => 1,
            ],
            [
                'category_code'           => 'BINDING',
                'code'                    => 'STD_BINDING_L',
                'name'                    => 'スタンダードビンディング L',
                'size_label'              => 'L',
                'brand'                   => '汎用',
                'model_name'              => '',
                'is_stock_managed'        => 1,
                'stock_qty'               => 8,
                'stock_warning_threshold' => 2,
                'note'                    => '',
                'is_active'               => 1,
            ],
            [
                'category_code'           => 'BINDING',
                'code'                    => 'STEP_ON_BINDING_M',
                'name'                    => 'Step On ビンディング M',
                'size_label'              => 'M',
                'brand'                   => 'Burton',
                'model_name'              => 'Step On',
                'is_stock_managed'        => 1,
                'stock_qty'               => 5,
                'stock_warning_threshold' => 1,
                'note'                    => 'Step On オプション用',
                'is_active'               => 1,
            ],
            [
                'category_code'           => 'BINDING',
                'code'                    => 'STEP_ON_BINDING_L',
                'name'                    => 'Step On ビンディング L',
                'size_label'              => 'L',
                'brand'                   => 'Burton',
                'model_name'              => 'Step On',
                'is_stock_managed'        => 1,
                'stock_qty'               => 4,
                'stock_warning_threshold' => 1,
                'note'                    => 'Step On オプション用',
                'is_active'               => 1,
            ],
            [
                'category_code'           => 'WEAR',
                'code'                    => 'WEAR_M_SET',
                'name'                    => 'ウェアセット M',
                'size_label'              => 'M',
                'brand'                   => '汎用',
                'model_name'              => '',
                'is_stock_managed'        => 0,
                'stock_qty'               => null,
                'stock_warning_threshold' => null,
                'note'                    => '在庫数は管理しない',
                'is_active'               => 1,
            ],
            [
                'category_code'           => 'WEAR',
                'code'                    => 'WEAR_L_SET',
                'name'                    => 'ウェアセット L',
                'size_label'              => 'L',
                'brand'                   => '汎用',
                'model_name'              => '',
                'is_stock_managed'        => 0,
                'stock_qty'               => null,
                'stock_warning_threshold' => null,
                'note'                    => '在庫数は管理しない',
                'is_active'               => 1,
            ],
            [
                'category_code'           => 'GLOVE',
                'code'                    => 'GLOVE_STD_M',
                'name'                    => 'グローブ M',
                'size_label'              => 'M',
                'brand'                   => '汎用',
                'model_name'              => '',
                'is_stock_managed'        => 0,
                'stock_qty'               => null,
                'stock_warning_threshold' => null,
                'note'                    => '在庫数は管理しない',
                'is_active'               => 1,
            ],
            [
                'category_code'           => 'GLOVE',
                'code'                    => 'GLOVE_STD_L',
                'name'                    => 'グローブ L',
                'size_label'              => 'L',
                'brand'                   => '汎用',
                'model_name'              => '',
                'is_stock_managed'        => 0,
                'stock_qty'               => null,
                'stock_warning_threshold' => null,
                'note'                    => '在庫数は管理しない',
                'is_active'               => 1,
            ],
            [
                'category_code'           => 'GOGGLE',
                'code'                    => 'GOGGLE_STD',
                'name'                    => 'ゴーグル フリーサイズ',
                'size_label'              => 'Free',
                'brand'                   => '汎用',
                'model_name'              => '',
                'is_stock_managed'        => 0,
                'stock_qty'               => null,
                'stock_warning_threshold' => null,
                'note'                    => '在庫数は管理しない',
                'is_active'               => 1,
            ],
            [
                'category_code'           => 'ACCESSORY',
                'code'                    => null,
                'name'                    => 'ヘルメット フリー',
                'size_label'              => 'Free',
                'brand'                   => '汎用',
                'model_name'              => '',
                'is_stock_managed'        => 0,
                'stock_qty'               => null,
                'stock_warning_threshold' => null,
                'note'                    => '将来利用予定',
                'is_active'               => 0,
            ],
        ];

        foreach ($items as $data) {
            // カテゴリコードからカテゴリID取得
            $category = GearItemCategory::where('code', $data['category_code'])->first();

            if (! $category) {
                // 対応カテゴリがない場合はスキップ
                continue;
            }

            // upsert用のキー条件
            if (!empty($data['code'])) {
                // code がある場合は code で一意
                $conditions = ['code' => $data['code']];
            } else {
                // code がない場合は カテゴリ + name + size_label で一意とみなす
                $conditions = [
                    'gear_item_category_id' => $category->id,
                    'name'                  => $data['name'],
                    'size_label'            => $data['size_label'] ?? null,
                ];
            }

            GearItem::updateOrCreate(
                $conditions,
                [
                    'gear_item_category_id'  => $category->id,
                    'name'                   => $data['name'],
                    'size_label'             => $data['size_label'] ?? null,
                    'brand'                  => $data['brand'] ?? null,
                    'model_name'             => $data['model_name'] ?: null,
                    'is_stock_managed'       => (bool) $data['is_stock_managed'],
                    'stock_qty'              => $data['stock_qty'] ?? null,
                    'stock_warning_threshold' => $data['stock_warning_threshold'] ?? null,
                    'note'                   => $data['note'] ?: null,
                    'is_active'              => (bool) $data['is_active'],
                    // create_user_id / update_user_id は今回は null のまま
                ]
            );
        }
    }
}
