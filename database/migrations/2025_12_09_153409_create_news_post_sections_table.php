<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 既存テーブルへの追加
        Schema::table('news_posts', function (Blueprint $table) {
            $table->text('closing_sentence')->nullable()->comment('締めの1文')->after('excerpt');
            // 既存の content カラムは使用しなくなりますが、念のため残しておきます
            $table->longText('content')->nullable()->change();
        });

        // 新規詳細（セクション）テーブル
        Schema::create('news_post_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('news_post_id')->constrained('news_posts')->onDelete('cascade');
            $table->string('heading')->nullable()->comment('見出し名');
            $table->longText('body')->nullable()->comment('メインテキスト');
            $table->text('note')->nullable()->comment('注意書き');
            $table->integer('sort_order')->default(0)->comment('表示順');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_post_sections');
        Schema::table('news_posts', function (Blueprint $table) {
            $table->dropColumn('closing_sentence');
        });
    }
};
