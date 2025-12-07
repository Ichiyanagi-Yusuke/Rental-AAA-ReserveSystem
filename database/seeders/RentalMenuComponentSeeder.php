<?php

namespace Database\Seeders;

use App\Models\GearItem;
use App\Models\RentalMenu;
use App\Models\RentalMenuComponent;
use Illuminate\Database\Seeder;

class RentalMenuComponentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * メニュー名 → 使用するギアコード一覧
         *
         * ※ ここでは「代表ギア」を1つずつ紐づけています。
         *   実際のサイズ割り当ては予約時に行う前提です。
         */
        $mapping = [
            // ───────── スノーボード系（メインギア） ─────────
            // Burton Custom セット：Custom ボード＋Burtonブーツ＋スタンダードビンディング
            'BurtonCustomセット' => [
                'BURTON_CUSTOM_154', // ボード
                'BURTON_BOOT_27',    // ブーツ
                'STD_BINDING_M',     // ビンディング
            ],

            // NewModelBurton セット：ここではスタンダードボード155 & スタンダードブーツ27 & ビンディングMを仮紐づけ
            'NewModelBurtonセット' => [
                'STD_BOARD_155',
                'STD_BOOT_27',
                'STD_BINDING_M',
            ],

            // スノーボードセット（大人）：スタンダードボード150 & ブーツ26 & ビンディングM
            'スノーボードセット' => [
                'STD_BOARD_150',
                'STD_BOOT_26',
                'STD_BINDING_M',
            ],

            // Jrスノーボードセット：現時点ではスタンダードボード150 & ブーツ26 & ビンディングMを仮で紐づけ
            // （将来 Jr 専用ギアを gear_items に追加したら、ここを書き換える想定）
            'Jrスノーボードセット' => [
                'STD_BOARD_150',
                'STD_BOOT_26',
                'STD_BINDING_M',
            ],

            // スノーボード板単品：スタンダードボード150のみ
            'スノーボード板単品' => [
                'STD_BOARD_150',
            ],

            // ───────── ウェア系 ─────────
            // ウェアセット（大人）：とりあえず M を代表として紐づけ（在庫管理なし）
            'ウェアセット' => [
                'WEAR_M_SET',
            ],

            // Jrウェアセット：現時点では M を代表として紐づけ（将来 Jr 用を追加したら変更）
            'Jrウェアセット' => [
                'WEAR_M_SET',
            ],

            // ───────── グローブ系（オプション） ─────────
            // グローブ：スタンダード M を代表として紐づけ（在庫管理なし）
            'グローブ' => [
                'GLOVE_STD_M',
            ],

            // ハイグレードグローブ：現時点では同じ M を代表として紐づけ（将来専用ギアを追加したら変更）
            'ハイグレードグローブ' => [
                'GLOVE_STD_M',
            ],

            // ───────── ゴーグル系（オプション） ─────────
            // ゴーグル：フリーサイズ
            'ゴーグル' => [
                'GOGGLE_STD',
            ],

            // ハイグレードゴーグル：現時点では同じギアを代表として紐づけ（将来専用ギアを追加したら変更）
            'ハイグレードゴーグル' => [
                'GOGGLE_STD',
            ],

            // ───────── Step On オプション ─────────
            // Step On オプション：Step On ビンディング M を代表として紐づけ
            'Step On オプション' => [
                'STEP_ON_BINDING_M',
            ],
        ];

        foreach ($mapping as $menuName => $gearCodes) {
            /** @var \App\Models\RentalMenu|null $menu */
            $menu = RentalMenu::where('name', $menuName)->first();

            if (! $menu) {
                // 対応するメニューが存在しなければスキップ
                continue;
            }

            foreach ($gearCodes as $code) {
                /** @var \App\Models\GearItem|null $gear */
                $gear = GearItem::where('code', $code)->first();

                if (! $gear) {
                    // 対応するギアが存在しなければスキップ
                    continue;
                }

                RentalMenuComponent::updateOrCreate(
                    [
                        'rental_menu_id' => $menu->id,
                        'gear_item_id'   => $gear->id,
                    ],
                    [
                        'quantity'   => 1,
                        'is_required' => true,
                    ]
                );
            }
        }
    }
}
