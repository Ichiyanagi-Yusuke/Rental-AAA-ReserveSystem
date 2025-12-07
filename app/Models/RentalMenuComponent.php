<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalMenuComponent extends Model
{
    use HasFactory;

    /**
     * 一括代入可能なカラム
     */
    protected $fillable = [
        'rental_menu_id',
        'gear_item_id',
        'quantity',
        'is_required',
    ];

    /**
     * メニュー（親）とのリレーション
     * 
     * rental_menu_components.rental_menu_id → rental_menus.id
     */
    public function menu()
    {
        return $this->belongsTo(RentalMenu::class, 'rental_menu_id');
    }

    /**
     * ギア（親）とのリレーション
     * 
     * rental_menu_components.gear_item_id → gear_items.id
     */
    public function gearItem()
    {
        return $this->belongsTo(GearItem::class, 'gear_item_id');
    }
}
