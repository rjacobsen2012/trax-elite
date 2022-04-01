<?php

namespace App\Policies;

use App\Models\Trip;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TripPolicy
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

    public function view(User $user, Trip $trip = null): bool
    {
        return !$trip?->user || $trip->user->id === $user->id;
    }

    public function delete(User $user, Trip $trip = null): bool
    {
        return !$trip?->user || $trip->user->id === $user->id;
    }
}
