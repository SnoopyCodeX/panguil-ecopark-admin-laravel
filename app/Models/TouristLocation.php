<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\TouristLocation
 *
 * @property int $id
 * @property int $user_id
 * @property float $latitude
 * @property float $longitude
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\TouristLocationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|TouristLocation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TouristLocation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TouristLocation query()
 * @method static \Illuminate\Database\Eloquent\Builder|TouristLocation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TouristLocation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TouristLocation whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TouristLocation whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TouristLocation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TouristLocation whereUserId($value)
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class TouristLocation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'latitude',
        'longitude',
        'status'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d h:i A',
        'updated_at' => 'datetime:Y-m-d h:i A',
    ];

    public function user() : HasOne {
        return $this->hasOne(User::class);
    }
}
