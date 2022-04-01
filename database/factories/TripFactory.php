<?php

namespace Database\Factories;

use App\Models\Car;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Trip>
 */
class TripFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'date' => Carbon::now(),
            'miles' => $this->faker->randomFloat(1, 0, 20),
            'car_id' => Car::factory(),
        ];
    }
}
