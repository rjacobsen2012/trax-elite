<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Collection;

/**
 * @property int id
 * @property string model
 * @property string make
 * @property Carbon year
 * @property-read Collection|Trip[] trips
 * @property-read User user
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property-read string name
 * @method static|Builder|QueryBuilder|Trip byUser(User|Authenticatable $user)
 */
class Car extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }

    public function getNameAttribute(): string
    {
        return $this->year . ' ' . $this->make . ' ' . $this->model;
    }

    public function scopeByUser(Builder|QueryBuilder $query, User|Authenticatable $user): Builder|QueryBuilder
    {
        return $query->whereUserId($user->id);
    }
}
