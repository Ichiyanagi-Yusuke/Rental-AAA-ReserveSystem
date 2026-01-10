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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            // 代表者情報
            $table->string('rep_last_name', 50);          // 代表者(性)
            $table->string('rep_first_name', 50);         // 代表者(名)
            $table->string('rep_last_name_kana', 50);     // 代表者ふりがな(性)
            $table->string('rep_first_name_kana', 50);    // 代表者ふりがな(名)

            $table->string('phone', 20);                  // 必須/電話番号
            $table->string('email');                      // 必須/メールアドレス

            // 来店・返却
            $table->date('visit_date');                   // 必須/来店予定日
            $table->time('visit_time');                   // 必須/来店予定時刻
            $table->date('return_date');                  // 必須/返却予定日
            $table->boolean('is_last_day_night')->default(false);  // 最終日のナイター利用

            // ゲレンデ（リゾート）紐付け
            $table->unsignedBigInteger('resort_id');      // 必須/Resorts.id と紐付け

            // その他
            $table->text('note')->nullable();             // その他ご要望

            // 注意事項の同意
            $table->boolean('is_terms_agreed')->default(false); // 注意事項の同意

            // 予約トークン（メールから変更/キャンセルに使用）
            $table->uuid('token')->unique();        // 必須/トークン（一意）

            // 予約組み上げ番号（visit_date + build_number でユニーク）
            $table->unsignedInteger('build_number')->nullable();

            // 印刷者・登録者・更新者
            $table->unsignedBigInteger('printed_user_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // インデックス・ユニーク制約
            $table->unique(['visit_date', 'build_number']); // build_number が null の行同士は重複OK

            // 外部キー
            $table->foreign('resort_id')
                ->references('id')
                ->on('resorts')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('printed_user_id')
                ->references('id')
                ->on('users')
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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
