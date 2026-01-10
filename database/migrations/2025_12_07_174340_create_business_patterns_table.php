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
        Schema::create('business_patterns', function (Blueprint $table) {
            $table->id();

            // パターン識別用
            $table->string('code', 20)->unique();     // 例: WEEKDAY, WEEKEND_LONG, CLOSED
            $table->string('name', 50);               // 表示名: 平日通常営業 など
            $table->string('description', 255)->nullable(); // 補足説明

            // 営業情報
            $table->boolean('is_open')->default(true); // 営業日かどうか
            $table->time('open_time')->nullable();     // 開店時間
            $table->time('close_time')->nullable();    // 閉店時間

            // カレンダー表示用カラーコード（任意）
            $table->string('color', 7)->nullable();    // 例: #3B82F6

            // 作成・更新者
            $table->unsignedBigInteger('create_user_id');
            $table->unsignedBigInteger('update_user_id')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // 外部キー
            $table->foreign('create_user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade');

            $table->foreign('update_user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_patterns');
    }
};
    