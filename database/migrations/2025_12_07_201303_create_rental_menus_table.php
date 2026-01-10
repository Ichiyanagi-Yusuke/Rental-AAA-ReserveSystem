<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rental_menus', function (Blueprint $table) {
            $table->id();

            // カテゴリ（スノーボード / スキー / ウェア…）
            $table->foreignId('rental_menu_category_id')
                ->constrained('rental_menu_categories')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            // ※ 必要に応じて onDelete を set null に変えてもOK

            // メニュー表示名
            $table->string('name', 100);

            // 説明（任意）
            $table->text('description')->nullable();

            // メニュー種別：base（メインギア）、option（追加オプション）など
            $table->string('menu_type', 20)->default('base');

            // Jr向けフラグ：0 = 大人, 1 = Jr
            $table->boolean('is_junior')->default(false);

            // 1日目の基本料金
            $table->unsignedInteger('base_price');

            // 連日利用時の基本額（2日目以降1日あたり等）／nullなら base_price と同じ扱い
            $table->unsignedInteger('consecutive_base_price')->nullable();

            // メニュー固有の基本割引額（Web予約割引など）
            $table->unsignedInteger('base_discount_amount')->default(0);

            // 有効/無効
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();

            // よく使う絞り込み用のインデックス
            $table->index(['menu_type', 'is_active']);
            $table->index(['is_junior']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_menus');
    }
};
