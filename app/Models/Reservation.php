<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Reservation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'rep_last_name',
        'rep_first_name',
        'rep_last_name_kana',
        'rep_first_name_kana',
        'phone',
        'email',
        'visit_date',
        'visit_time',
        'return_date',
        'is_last_day_night',
        'resort_id',
        'note',
        'is_terms_agreed',
        'token',
        'build_number',
        'printed_user_id',
        'printed_at',
        'created_by',
        'updated_by',
        'is_staff_verified',
        'version',
        'is_needs_confirmation', // 追加
        'is_cancel_needs_confirmation',
        'is_comment_checked',
    ];

    protected $casts = [
        'visit_date'        => 'date',
        'visit_time'        => 'datetime:H:i',
        'return_date'       => 'date',
        'is_last_day_night' => 'boolean',
        'is_terms_agreed'   => 'boolean',
        'printed_at'  => 'datetime',
        'is_cancel_needs_confirmation' => 'boolean',
        'is_comment_checked' => 'boolean',
    ];

    /**
     * 予約作成時に token が空なら UUID を自動採番
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function (Reservation $reservation) {
            if (empty($reservation->token)) {
                $reservation->token = (string) Str::uuid();
            }
        });
    }

    /** 代表者氏名（苗字+名前）をまとめて取得できるアクセサ（お好み） */
    public function getRepFullNameAttribute(): string
    {
        return $this->rep_last_name . ' ' . $this->rep_first_name;
    }

    public function getRepFullNameKanaAttribute(): string
    {
        return $this->rep_last_name_kana . ' ' . $this->rep_first_name_kana;
    }

    // ---------- リレーション ----------

    /** 利用リゾート */
    public function resort()
    {
        return $this->belongsTo(Resort::class);
    }

    /** 予約詳細（利用者ごとの明細） */
    public function details()
    {
        return $this->hasMany(ReservationDetail::class);
    }

    /** 印刷者 */
    public function printedBy()
    {
        return $this->belongsTo(User::class, 'printed_user_id');
    }

    /** 登録者 */
    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by'); 
    }

    /** 更新者 */
    public function updatedByUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // 過去の予約へのリレーション（履歴管理用）
    public function originReservation()
    {
        return $this->belongsTo(Reservation::class, 'origin_reservation_id');
    }
}
