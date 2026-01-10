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
        Schema::create('business_calendars', function (Blueprint $table) {
            $table->id();

            // 日付ごとに1行
            $table->date('date')->unique();

            // 営業パターンとの紐付け
            $table->unsignedBigInteger('business_pattern_id');

            // シーズン管理
            $table->smallInteger('season_year');        // 例: 2024シーズン = 2024
            $table->boolean('is_peak')->default(false); // 繁忙フラグ
            $table->string('memo', 255)->nullable();    // 備考（大雪・臨時休業など）

            // 作成・更新者
            $table->unsignedBigInteger('create_user_id');
            $table->unsignedBigInteger('update_user_id')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // 外部キー
            $table->foreign('business_pattern_id')
                ->references('id')
                ->on('business_patterns')
                ->onUpdate('cascade');

            $table->foreign('create_user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade');

            $table->foreign('update_user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('set null');

            // よく使うであろう組み合わせにインデックス
            $table->index(['season_year', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_calendars');
    }
};
