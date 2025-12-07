<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resort extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'price',
        'holiday_price',
        'ticket',
        'sales_stop',
        'create_user_id',
        'update_user_id',
    ];

    protected $casts = [
        'sales_stop' => 'boolean',
    ];

    // 作成者
    public function createUser()
    {
        return $this->belongsTo(User::class, 'create_user_id');
    }

    // 更新者
    public function updateUser()
    {
        return $this->belongsTo(User::class, 'update_user_id');
    }
}
