<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ERentalReservation extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'reception_at' => 'datetime',
        'visit_date' => 'date',
        'visit_time' => 'datetime', // 時間計算しやすいようにdatetimeキャスト推奨、またはstring
    ];

    public function details(): HasMany
    {
        return $this->hasMany(ERentalReservationDetail::class);
    }

    // PDF生成時に既存テンプレートと互換性を持たせるためのアクセサ

    /**
     * 代表者姓（既存テンプレート互換用）
     */
    public function getRepLastNameAttribute(): string
    {
        // rep_nameから姓を抽出（スペースで分割）
        $parts = explode(' ', $this->rep_name ?? '');
        return $parts[0] ?? '';
    }

    /**
     * 代表者名（既存テンプレート互換用）
     */
    public function getRepFirstNameAttribute(): string
    {
        // rep_nameから名を抽出（スペースで分割）
        $parts = explode(' ', $this->rep_name ?? '');
        return $parts[1] ?? '';
    }

    /**
     * 代表者姓カナ（既存テンプレート互換用）
     */
    public function getRepLastNameKanaAttribute(): string
    {
        // rep_kanaから姓カナを抽出（スペースで分割）
        $parts = explode(' ', $this->rep_kana ?? '');
        return $parts[0] ?? '';
    }

    /**
     * 代表者名カナ（既存テンプレート互換用）
     */
    public function getRepFirstNameKanaAttribute(): string
    {
        // rep_kanaから名カナを抽出（スペースで分割）
        $parts = explode(' ', $this->rep_kana ?? '');
        return $parts[1] ?? '';
    }

    /**
     * 返却日（既存テンプレート互換用）
     * Eレンタルは返却日がないため、来店日と同じ日を返す
     */
    public function getReturnDateAttribute()
    {
        return $this->visit_date;
    }

    /**
     * コメント（既存テンプレート互換用）
     */
    public function getNoteAttribute(): ?string
    {
        return $this->attributes['comment'] ?? null;
    }
}
