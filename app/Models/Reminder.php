<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Reminder
 *
 * @property int $id
 * @property string $name
 * @property string $content
 * @property string $profile
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\ReminderFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Reminder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reminder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reminder query()
 * @method static \Illuminate\Database\Eloquent\Builder|Reminder whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reminder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reminder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reminder whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reminder whereProfile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reminder whereUpdatedAt($value)
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Reminder extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'content',
        'profile',
    ];
}
