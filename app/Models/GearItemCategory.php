<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GearItemCategory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'sort_order',
        'is_active',
    ];

    public function gearItems()
    {
        return $this->hasMany(GearItem::class);
    }
}
    