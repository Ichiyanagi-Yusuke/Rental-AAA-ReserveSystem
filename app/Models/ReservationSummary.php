<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // ★追加

class ReservationSummary extends Model
{

    use SoftDeletes;
    // ビューの名前を指定
    protected $table = 'reservation_summaries';

    // ビューなのでIDは自動増分ではないことを指定
    public $incrementing = false;
    protected $keyType = 'string';

    // タイムスタンプの自動更新を無効化（読み取り専用のため）
    public $timestamps = false;

    // 日付キャスト
    protected $casts = [
        'visit_date' => 'date',
        'visit_time' => 'datetime',
        'created_at' => 'datetime',
    ];

    /**
     * Eレンタルからの予約かどうか判定
     */
    public function isExternal(): bool
    {
        return $this->source === 'external';
    }
}
