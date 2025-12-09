<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rental_menus', function (Blueprint $table) {
            if (! Schema::hasColumn('rental_menus', 'is_set_menu')) {
                $table->boolean('is_set_menu')
                    ->default(false)
                    ->after('is_junior'); // is_junior の直後などでOK
            }
        });
    }

    public function down(): void
    {
        Schema::table('rental_menus', function (Blueprint $table) {
            if (Schema::hasColumn('rental_menus', 'is_set_menu')) {
                $table->dropColumn('is_set_menu');
            }
        });
    }
};
