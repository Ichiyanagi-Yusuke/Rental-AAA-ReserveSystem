<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ERentalReservationDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(ERentalReservation::class, 'e_rental_reservation_id');
    }

    // PDF生成時に既存テンプレートと互換性を持たせるためのアクセサ

    /**
     * メインギアメニュー（既存テンプレート互換用）
     * Eレンタルではアイテム情報がitems_textに含まれているため、nullを返す
     */
    public function getMainGearMenuAttribute()
    {
        return null;
    }

    /**
     * ウェアメニュー（既存テンプレート互換用）
     */
    public function getWearMenuAttribute()
    {
        return null;
    }

    /**
     * グローブメニュー（既存テンプレート互換用）
     */
    public function getGloveMenuAttribute()
    {
        return null;
    }

    /**
     * ゴーグルメニュー（既存テンプレート互換用）
     */
    public function getGoggleMenuAttribute()
    {
        return null;
    }

    /**
     * ヘルメット使用フラグ（既存テンプレート互換用）
     * Eレンタルではitems_textから判定できないため、falseを返す
     */
    public function getIsHelmetUsedAttribute(): bool
    {
        // items_textに「ヘルメット」が含まれているか簡易チェック
        return str_contains($this->items_text ?? '', 'ヘルメット');
    }

    /**
     * ウェアサイズ（既存テンプレート互換用）
     */
    public function getWearSizeAttribute(): string
    {
        return '';
    }

    /**
     * グローブサイズ（既存テンプレート互換用）
     */
    public function getGloveSizeAttribute(): string
    {
        return '';
    }
}
