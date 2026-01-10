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
        Schema::create('reservation_details', function (Blueprint $table) {
            $table->id();

            // 親予約
            $table->unsignedBigInteger('reservation_id'); // 必須/予約ヘッダーID

            // 利用者情報
            $table->string('guest_name', 100);            // 必須/利用者名
            $table->string('guest_name_kana', 100);       // 必須/フリガナ

            // 性別（例: 'woman', 'man', 'other' などをドロップダウンで選択）
            $table->string('gender', 20);  // 必須カラム想定

            // 子供フラグ
            $table->boolean('is_child')->default(false);

            // 体格情報
            $table->unsignedSmallInteger('height')->nullable(); // cm
            $table->decimal('foot_size', 4, 1)->nullable();     // 例: 27.5

            // スタンス（例: 'レギュラー', 'グーフィー', 'フリー' など）
            $table->string('stance', 50)->nullable();

            // 各種レンタルプラン（rental_menus.id と紐付け）
            $table->unsignedBigInteger('main_gear_menu_id')->nullable();   // メインギアプラン
            $table->unsignedBigInteger('wear_menu_id')->nullable();        // ウェアプラン
            $table->string('wear_size', 20)->nullable();                   // ウェアサイズ
            $table->unsignedBigInteger('glove_menu_id')->nullable();       // グローブプラン
            $table->string('glove_size', 20)->nullable();                  // グローブサイズ
            $table->unsignedBigInteger('goggle_menu_id')->nullable();      // ゴーグルプラン

            // ヘルメット利用
            $table->boolean('is_helmet_used')->default(false);

            // その他ご要望
            $table->text('note')->nullable();

            // グループ内連番（同一予約内での並び順）
            $table->unsignedInteger('group_sequence')->default(1);

            // 登録者・更新者
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();
            $table->softDeletes(); // 削除フラグとして運用

            // 外部キー
            $table->foreign('reservation_id')
                ->references('id')
                ->on('reservations')
                ->onDelete('cascade')     // 親予約削除時に子も削除
                ->onUpdate('cascade');

            $table->foreign('main_gear_menu_id')
                ->references('id')
                ->on('rental_menus')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('wear_menu_id')
                ->references('id')
                ->on('rental_menus')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('glove_menu_id')
                ->references('id')
                ->on('rental_menus')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('goggle_menu_id')
                ->references('id')
                ->on('rental_menus')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('updated_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservation_details');
    }
};
