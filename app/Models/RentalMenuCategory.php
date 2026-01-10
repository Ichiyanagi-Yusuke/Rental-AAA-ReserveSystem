<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RentalMenuCategory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'sort_order',
        'is_active',
    ];

    public function rentalMenus()
    {
        return $this->hasMany(RentalMenu::class);
    }
}