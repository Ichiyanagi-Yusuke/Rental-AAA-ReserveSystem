<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RentalMenu extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'rental_menu_category_id',
        'name',
        'description',
        'menu_type',
        'is_junior',
        'base_price',
        'is_set_menu',
        'consecutive_base_price',
        'base_discount_amount',
        'is_active',
    ];

    protected $casts = [
        'is_active'    => 'boolean',
        'is_junior'    => 'boolean',
        'is_set_menu'  => 'boolean',   // ★ 追加
    ];

    public function category()
    {
        return $this->belongsTo(RentalMenuCategory::class, 'rental_menu_category_id');
    }

    public function components()
    {
        return $this->hasMany(RentalMenuComponent::class);
    }

    public function gearItems()
    {
        return $this->belongsToMany(GearItem::class, 'rental_menu_components')
            ->withPivot('quantity', 'is_required')
            ->withTimestamps();
    }
}