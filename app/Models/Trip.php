<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder as QueryBuilder;

/**
 * @property int id
 * @property Carbon date
 * @property float miles
 * @property float total
 * @property-read User user
 * @property-read Car car
 * @property Carbon created_at
 * @property Carbon updated_at
 * @method static|Builder|QueryBuilder|Trip byCar(Car $car)
 * @method static|Builder|QueryBuilder|Trip byUser(User|Authenticatable $user)
 * @method static|Builder|QueryBuilder|Trip orderByLatest()
 */
class Trip extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'date' => 'datetime',
        'miles' => 'float',
        'total' => 'float',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function scopeByCar(Builder|QueryBuilder $query, Car $car): Builder|QueryBuilder
    {
        return $query->whereHas('car', function (Builder|QueryBuilder $query) use ($car) {
            $query->where('id', $car->id);
        });
    }

    public function scopeOrderByLatest(Builder|QueryBuilder $query): Builder|QueryBuilder
    {
        return $query->orderBy('id', 'desc');
    }

    public function scopeByUser(Builder|QueryBuilder $query, User|Authenticatable $user): Builder|QueryBuilder
    {
        return $query->whereUserId($user->id);
    }
}
