<?php

namespace App\Models\Tourist;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailableReservation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'price_per_head',
        'children_discount',
        'name_of_spot',
        'size_of_spot',
        'description',
        'photo',
        'status'
    ];
}
