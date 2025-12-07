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
        Schema::create('gear_items', function (Blueprint $table) {
            $table->id();

            // ギアカテゴリ（ボード / ブーツ / StepOn / ウェア…）
            $table->foreignId('gear_item_category_id')
                ->constrained('gear_item_categories')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            // ※ カテゴリ削除を許容したいなら nullOnDelete + nullable() に変更も可

            // システム用コード（任意・ユニーク推奨）
            $table->string('code', 50)->nullable()->unique();

            // 表示名（例：スタンダードボード 150cm）
            $table->string('name', 100);

            // サイズラベル（150cm, 27.0, M 等）
            $table->string('size_label', 50)->nullable();

            // メーカー・ブランド
            $table->string('brand', 50)->nullable();

            // モデル名
            $table->string('model_name', 100)->nullable();

            // 在庫管理するかどうか
            $table->boolean('is_stock_managed')->default(true);

            // 在庫数（在庫管理するギアのみ使用）
            $table->unsignedInteger('stock_qty')->nullable();

            // 残りがこの数を下回ったら警告…などに使える
            $table->unsignedInteger('stock_warning_threshold')->nullable();

            // 備考
            $table->text('note')->nullable();

            // 有効/無効
            $table->boolean('is_active')->default(true);

            // 作成・更新ユーザー（任意）
            $table->foreignId('create_user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('update_user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->timestamps();
            $table->softDeletes();

            // 検索用インデックス
            $table->index(['gear_item_category_id', 'is_stock_managed']);
            $table->index(['is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gear_items');
    }
};
