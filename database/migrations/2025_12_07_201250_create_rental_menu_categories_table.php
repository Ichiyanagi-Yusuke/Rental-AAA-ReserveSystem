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
        Schema::create('rental_menu_categories', function (Blueprint $table) {
            $table->id();

            // 表示名（例：スノーボード、スキー）
            $table->string('name', 100);

            // 並び順
            $table->unsignedInteger('sort_order')->default(0);

            // 有効 / 無効
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_menu_categories');
    }
};
