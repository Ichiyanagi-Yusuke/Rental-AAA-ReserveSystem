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
        Schema::table('reservations', function (Blueprint $table) {
            // 前回の変更確認フラグの後ろあたりに追加
            $table->boolean('is_cancel_needs_confirmation')
                ->default(false)
                ->after('is_needs_confirmation')
                ->comment('印刷後にキャンセルされ、スタッフの確認が必要な場合true');
        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn('is_cancel_needs_confirmation');
        });
    }
};
