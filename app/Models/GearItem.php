<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GearItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'gear_item_category_id',
        'code',
        'name',
        'size_label',
        'brand',
        'model_name',
        'is_stock_managed',
        'stock_qty',
        'stock_warning_threshold',
        'note',
        'is_active',
        'create_user_id',
        'update_user_id',
    ];

    public function category()
    {
        return $this->belongsTo(GearItemCategory::class, 'gear_item_category_id');
    }

    public function components()
    {
        return $this->hasMany(RentalMenuComponent::class);
    }

    public function menus()
    {
        return $this->belongsToMany(RentalMenu::class, 'rental_menu_components')
            ->withPivot('quantity', 'is_required')
            ->withTimestamps();
    }
}
