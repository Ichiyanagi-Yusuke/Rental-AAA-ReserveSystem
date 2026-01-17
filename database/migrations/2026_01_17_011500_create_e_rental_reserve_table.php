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
        // Eレンタル予約ヘッダーテーブル
        Schema::create('e_rental_reservations', function (Blueprint $table) {
            $table->id();

            // Eレンタルの予約番号 (一意制約)
            $table->string('reservation_number')->unique()->comment('Eレンタルの予約番号: 1735133530');

            // 予約受付情報
            $table->dateTime('reception_at')->comment('予約受付日時');

            // 代表者情報
            $table->string('rep_name')->comment('申込代表者名');
            $table->string('rep_kana')->comment('申込代表者カナ');
            $table->string('address')->nullable()->comment('住所'); // 既存にはない項目
            $table->string('phone', 20);

            // メールアドレス (PC/携帯)
            $table->string('email_pc')->nullable();
            $table->string('email_mobile')->nullable();

            // 来店・利用情報
            $table->date('visit_date')->comment('受取予定日');
            $table->time('visit_time')->comment('受取予定時刻');
            $table->integer('rental_days')->default(1)->comment('レンタル期間(日)');
            $table->integer('number_of_people')->default(1)->comment('人数');

            // 金額情報
            $table->integer('total_price')->default(0)->comment('合計金額');

            // その他
            $table->text('comment')->nullable()->comment('コメント');

            // 本システムへの取込ステータス (例: 0:未取込, 1:取込済, 9:エラー)
            $table->tinyInteger('import_status')->default(0)->comment('0:未反映, 1:反映済');

            $table->timestamps();
            $table->softDeletes();
        });

        // Eレンタル予約明細テーブル
        Schema::create('e_rental_reservation_details', function (Blueprint $table) {
            $table->id();

            // 親テーブルとの紐付け
            $table->unsignedBigInteger('e_rental_reservation_id');

            // 利用者情報
            $table->string('guest_name')->comment('利用者名');
            // 必要に応じてカナも保存する場合はカラム追加

            $table->string('gender', 20)->comment('性別');
            $table->unsignedTinyInteger('age')->nullable()->comment('年齢'); // 既存にはない項目

            // 体格情報
            $table->unsignedSmallInteger('height')->nullable()->comment('身長cm');
            $table->decimal('foot_size', 4, 1)->nullable()->comment('足サイズcm');
            $table->unsignedSmallInteger('weight')->nullable()->comment('体重kg'); // 既存にはない項目

            // スタンス
            $table->string('stance', 50)->nullable()->comment('ボードのスタンス');

            // レンタルアイテム内容
            // 外部キー制約は付けず、メール本文のアイテム記述（例: "スノーボード セット", "ウェア"）を
            // 解析してテキストやJSONで保存することを想定
            $table->text('items_text')->nullable()->comment('レンタルアイテム内容（解析用生データ）');
            $table->integer('subtotal_price')->default(0)->comment('小計');

            $table->timestamps();
            $table->softDeletes();

            // 外部キー制約
            $table->foreign('e_rental_reservation_id')
                ->references('id')
                ->on('e_rental_reservations')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('e_rental_reservation_details');
        Schema::dropIfExists('e_rental_reservations');
    }
};
