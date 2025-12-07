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
            Schema::create('resorts', function (Blueprint $table) {
        $table->id();
            
        $table->string('name', 50)->unique();                 // リゾート名
        $table->unsignedInteger('price');                     // 通常料金
        $table->unsignedInteger('holiday_price');             // 休日料金
        $table->unsignedInteger('ticket')->default(0);        // チケット枚数など
        $table->boolean('sales_stop')->default(false);        // 販売停止フラグ
            
        $table->foreignId('create_user_id')                   // 作成者
            ->nullable()
            ->constrained('users')
            ->nullOnDelete()
            ->cascadeOnUpdate();
            
        $table->foreignId('update_user_id')                   // 最終更新者
            ->nullable()
            ->constrained('users')
            ->nullOnDelete()
            ->cascadeOnUpdate();
            
        $table->timestamps();
        $table->softDeletes();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resorts');
    }
};
