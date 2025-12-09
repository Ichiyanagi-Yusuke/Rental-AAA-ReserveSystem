<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReservationDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'reservation_id',
        'guest_name',
        'guest_name_kana',
        'gender',
        'is_child',
        'height',
        'foot_size',
        'stance',
        'main_gear_menu_id',
        'wear_menu_id',
        'wear_size',
        'glove_menu_id',
        'glove_size',
        'goggle_menu_id',
        'is_helmet_used',
        'is_step_on',
        'note',
        'group_sequence',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_child'       => 'boolean',
        'is_helmet_used' => 'boolean',
        'height'         => 'integer',
        'foot_size'      => 'float',
        'group_sequence' => 'integer',
        'is_step_on',
    ];

    // ---------- リレーション ----------

    /** 親予約ヘッダー */
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    /** メインギアプラン */
    public function mainGearMenu()
    {
        return $this->belongsTo(RentalMenu::class, 'main_gear_menu_id');
    }

    /** ウェアプラン */
    public function wearMenu()
    {
        return $this->belongsTo(RentalMenu::class, 'wear_menu_id');
    }

    /** グローブプラン */
    public function gloveMenu()
    {
        return $this->belongsTo(RentalMenu::class, 'glove_menu_id');
    }

    /** ゴーグルプラン */
    public function goggleMenu()
    {
        return $this->belongsTo(RentalMenu::class, 'goggle_menu_id');
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
}
