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
            // 注意事項同意フラグの後ろあたりに追加
            $table->boolean('is_needs_confirmation')
                ->default(false)
                ->after('is_terms_agreed')
                ->comment('変更がありスタッフの確認が必要な場合true');
        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn('is_needs_confirmation');
        });
    }
};
