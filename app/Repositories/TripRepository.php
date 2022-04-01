<?php

namespace App\Repositories;

use App\Models\Trip;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;

class TripRepository
{
    public function addTrip(array $tripData)
    {
        /** @var User $user */
        $user = auth()->user();
        $this->verifyTotals($user);
        return $user->trips()->create($tripData);
    }

    /**
     * @throws Exception
     */
    public function removeTrip(Trip $trip)
    {
        $trip->delete();
        $this->verifyTotals(auth()->user());
    }

    protected function verifyTotals(User|Authenticatable $user)
    {
        $total = 0;
        /** @var Trip $trip */
        foreach ($user->trips()->orderBy('id', 'asc')->get() as $trip) {
            $total += $trip->miles;
            $trip->total = $total;
            $trip->save();
        }
    }
}
