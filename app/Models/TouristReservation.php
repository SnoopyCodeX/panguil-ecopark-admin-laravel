<?php

namespace App\Models;

use App\Models\Tourist\AvailableReservation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TouristReservation extends Model
{
    use HasFactory;

    public function user() : BelongsTo
    {
        return $this->belongsTo(Tourist::class);
    }

    public function reservationType() : BelongsTo
    {
        return $this->belongsTo(AvailableReservation::class, 'reservation_id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'reservation_id',
        'number_of_adults',
        'number_of_children',
        'reserve_date',
        'arrival_time',
        'phone_number'
    ];
}
