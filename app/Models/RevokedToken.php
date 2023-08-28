<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\RevokedToken
 *
 * @property int $id
 * @property string $token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\RevokedTokenFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|RevokedToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RevokedToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RevokedToken query()
 * @method static \Illuminate\Database\Eloquent\Builder|RevokedToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RevokedToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RevokedToken whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RevokedToken whereUpdatedAt($value)
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class RevokedToken extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'token'
    ];
}
