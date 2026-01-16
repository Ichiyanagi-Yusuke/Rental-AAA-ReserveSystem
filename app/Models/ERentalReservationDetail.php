<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ERentalReservationDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(ERentalReservation::class, 'e_rental_reservation_id');
    }
}
