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
            // 印刷日時
            $table->timestamp('printed_at')
                ->nullable()
                ->after('build_number') // build_numberの後ろに追加
                ->comment('帳票印刷日時');

            // 印刷実行者 (usersテーブルのID)
            $table->foreignId('printed_user_id')
                ->nullable()
                ->after('printed_at')
                ->constrained('users') // usersテーブルと紐付け
                ->nullOnDelete()       // ユーザーが削除されたらNULLにする
                ->comment('印刷実行者ID');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('e_rental_reservations', function (Blueprint $table) {
            // 外部キー制約を先に削除してからカラムを削除
            $table->dropForeign(['printed_user_id']);
            $table->dropColumn(['printed_at', 'printed_user_id']);
        });
    }
};
