<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessCalendar extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'date',
        'business_pattern_id',
        'season_year',
        'is_peak',
        'memo',
        'create_user_id',
        'update_user_id',
    ];

    protected $casts = [
        'date'    => 'date',
        'is_peak' => 'boolean',
    ];

    public function pattern()
    {
        return $this->belongsTo(BusinessPattern::class, 'business_pattern_id');
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
