<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('タイトル');
            $table->string('category')->comment('カテゴリー(news, blog, event)');
            $table->text('excerpt')->nullable()->comment('一覧用抜粋文');
            $table->longText('content')->comment('本文');
            $table->string('thumbnail')->nullable()->comment('サムネイル画像パス');
            $table->date('published_at')->comment('公開日');
            $table->boolean('is_published')->default(true)->comment('公開フラグ');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_posts');
    }
};
