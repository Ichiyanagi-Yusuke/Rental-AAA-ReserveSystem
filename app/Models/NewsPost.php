<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'excerpt',
        'content', // 互換性のため残存
        'closing_sentence', // 追加
        'thumbnail',
        'published_at',
        'is_published',
    ];

    protected $casts = [
        'published_at' => 'date',
        'is_published' => 'boolean',
    ];

    public function getCategoryLabelAttribute()
    {
        return match ($this->category) {
            'news' => 'お知らせ',
            'blog' => 'ブログ',
            'event' => 'イベント',
            default => 'その他',
        };
    }

    // セクションとのリレーション
    public function sections()
    {
        return $this->hasMany(NewsPostSection::class)->orderBy('sort_order', 'asc');
    }
}
