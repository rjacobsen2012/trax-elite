<?php

namespace App\Policies;

use App\Models\Car;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CarPolicy
{
    use HandlesAuthorization;

    public function viewAll(User $user): bool
    {
        return true;
    }

    public function store(User $user): bool
    {
        return true;
    }

    public function view(User $user, Car $car = null): bool
    {
        return !$car?->user || $car->user->id === $user->id;
    }

    public function delete(User $user, Car $car = null): bool
    {
        return !$car || ($car->user->id === $user->id && $car->trips->count() === 0);
    }
}
