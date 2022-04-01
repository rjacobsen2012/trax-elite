<?php

namespace App\Repositories;

use App\Models\Car;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Model;

class CarRepository
{
    public function addCar(array $carData): Model|Car
    {
        /** @var User $user */
        $user = auth()->user();
        return $user->cars()->create($carData);
    }

    /**
     * @throws Exception
     */
    public function removeCar(Car $car)
    {
        $car->delete();
    }
}
