<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Geofence
 *
 * @method static \Database\Factories\GeofenceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Geofence newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Geofence newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Geofence query()
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Geofence extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'geojson'
    ];
}
