<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsPostSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'news_post_id',
        'heading',
        'body',
        'note',
        'sort_order',
    ];

    public function post()
    {
        return $this->belongsTo(NewsPost::class, 'news_post_id');
    }
}
