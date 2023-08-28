<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TouristsToGuide
 *
 * @property int $id
 * @property string $tour_guide_name
 * @property string $assigned_datetime
 * @property string $tourist_name
 * @property int $age
 * @property string $gender
 * @property string $contact_number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\TouristsToGuideFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|TouristsToGuide newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TouristsToGuide newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TouristsToGuide query()
 * @method static \Illuminate\Database\Eloquent\Builder|TouristsToGuide whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TouristsToGuide whereAssignedDatetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TouristsToGuide whereContactNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TouristsToGuide whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TouristsToGuide whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TouristsToGuide whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TouristsToGuide whereTourGuideName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TouristsToGuide whereTouristName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TouristsToGuide whereUpdatedAt($value)
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class TouristsToGuide extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tourists_to_guide';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tour_guide_name',
        'assigned_datetime',
        'tourist_name',
        'age',
        'gender',
        'contact_number',
    ];
}
