<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Reservation
 *
 * @property int $id
 * @property string $name
 * @property string $gender
 * @property int $age
 * @property string $contact_number
 * @property int $number_of_tourists
 * @property int $assigned_tour_guide
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\ReservationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereAssignedTourGuide($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereContactNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereNumberOfTourists($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereUpdatedAt($value)
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Reservation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'gender',
        'age',
        'contact_number',
        'nuumber_of_tourists',
        'assigned_tour_guide',
    ];
}
