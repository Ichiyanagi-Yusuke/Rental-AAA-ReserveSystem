<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservation_details', function (Blueprint $table) {
            if (! Schema::hasColumn('reservation_details', 'is_step_on')) {
                $table->boolean('is_step_on')
                    ->default(false)
                    ->after('goggle_menu_id'); // 位置はお好みで
            }
        });
    }

    public function down(): void
    {
        Schema::table('reservation_details', function (Blueprint $table) {
            if (Schema::hasColumn('reservation_details', 'is_step_on')) {
                $table->dropColumn('is_step_on');
            }
        });
    }
};
