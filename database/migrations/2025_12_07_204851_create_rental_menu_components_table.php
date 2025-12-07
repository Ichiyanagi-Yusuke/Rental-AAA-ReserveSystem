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
        Schema::create('rental_menu_components', function (Blueprint $table) {
            $table->id();

            // 対象メニュー
            $table->foreignId('rental_menu_id')
                ->constrained('rental_menus')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // 使用するギア
            $table->foreignId('gear_item_id')
                ->constrained('gear_items')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // このメニューで何個使うか（通常 1）
            $table->unsignedTinyInteger('quantity')->default(1);

            // 必須かどうか
            $table->boolean('is_required')->default(true);

            $table->timestamps();

            // 同じメニュー × 同じギアの重複登録を防ぐ
            $table->unique(['rental_menu_id', 'gear_item_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_menu_components');
    }
};
