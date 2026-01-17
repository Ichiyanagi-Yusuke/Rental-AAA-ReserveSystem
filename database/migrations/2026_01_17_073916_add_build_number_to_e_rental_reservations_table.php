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
        Schema::table('e_rental_reservations', function (Blueprint $table) {
            // token は存在しないため reservation_number の後ろに追加します
            $table->unsignedInteger('build_number')->nullable()->after('reservation_number')->comment('予約組み上げ番号');

            // 検索・ソート用インデックス
            $table->index(['visit_date', 'build_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('e_rental_reservations', function (Blueprint $table) {
            $table->dropColumn('build_number');
        });
    }
};
