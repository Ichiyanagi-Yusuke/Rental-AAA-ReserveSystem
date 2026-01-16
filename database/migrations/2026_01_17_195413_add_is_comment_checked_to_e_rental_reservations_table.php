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
            // コメント確認済みフラグ
            $table->boolean('is_comment_checked')->default(false)->after('comment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('e_rental_reservations', function (Blueprint $table) {
            $table->dropColumn('is_comment_checked');
        });
    }
};
