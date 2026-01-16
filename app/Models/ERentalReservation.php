<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ERentalReservation extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'reception_at' => 'datetime',
        'visit_date' => 'date',
        'visit_time' => 'datetime', // 時間計算しやすいようにdatetimeキャスト推奨、またはstring
    ];

    public function details(): HasMany
    {
        return $this->hasMany(ERentalReservationDetail::class);
    }
}
