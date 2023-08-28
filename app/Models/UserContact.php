<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\UserContact
 *
 * @property int $id
 * @property int $user_id
 * @property string $contact_name
 * @property string $contact_role
 * @property string $contact_number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\UserContactFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|UserContact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserContact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserContact query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserContact whereContactName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserContact whereContactNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserContact whereContactRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserContact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserContact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserContact whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserContact whereUserId($value)
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class UserContact extends Model
{
    use HasFactory;

    /**
     * Get the owner of this contact
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'contact_name',
        'contact_role',
        'contact_number',
    ];

}
