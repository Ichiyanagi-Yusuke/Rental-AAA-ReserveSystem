<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessPattern extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'description',
        'is_open',
        'open_time',
        'close_time',
        'color',
        'create_user_id',
        'update_user_id',
    ];

    // カレンダーとのリレーション
    public function calendars()
    {
        return $this->hasMany(BusinessCalendar::class);
    }

    public function createUser()
    {
        return $this->belongsTo(User::class, 'create_user_id');
    }

    public function updateUser()
    {
        return $this->belongsTo(User::class, 'update_user_id');
    }
}
