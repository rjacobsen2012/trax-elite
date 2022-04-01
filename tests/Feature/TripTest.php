<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\Trip;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class TripTest extends TestCase
{
    /** @var Carbon */
    protected $now;

    protected function setUp(): void
    {
        parent::setUp();
        $this->login();
        Carbon::setTestNow($this->now = Carbon::now());
    }

    public function testTripIndex()
    {
        Trip::factory()->times(5)->create([
            'user_id' => $this->user->id,
            'car_id' => Car::factory()->create(['user_id' => $this->user->id])
        ]);
        $this->get(route('trip.index'))
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('Trip/Index')
                    ->has('trips')
            );
    }

    public function testTripCreate()
    {
        Car::factory()->times(5)->create(['user_id' => $this->user->id]);
        $this->get(route('trip.create'))
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('Trip/Create')
                    ->has('cars', 5)
            );
    }

    public function testTripStore()
    {
        $trip = [
            'date' => $this->now,
        ];

        $response = $this->post(route('trip.store'), $trip);
        $response->assertStatus(302);
        $this->assertDatabaseMissing('trips', [
            'date' => Arr::get($trip, 'date'),
        ]);

        $trip['miles'] = $this->faker->randomFloat(2, 0, 20);

        $response = $this->post(route('trip.store'), $trip);
        $response->assertStatus(302);
        $this->assertDatabaseMissing('trips', [
            'date' => Arr::get($trip, 'date'),
            'miles' => Arr::get($trip, 'miles'),
        ]);

        $trip['car_id'] = $carId = Car::factory()->create(['user_id' => $this->user->id])->getKey();

        $response = $this->post(route('trip.store'), $trip);
        $response->assertRedirect(route('trip.index'));
        $this->assertDatabaseHas('trips', [
            'date' => Arr::get($trip, 'date'),
            'miles' => Arr::get($trip, 'miles'),
            'total' => Arr::get($trip, 'miles'),
            'car_id' => $carId,
        ]);

        $newTrip = [
            'date' => $this->now->copy()->subDays(2),
            'miles' => $this->faker->randomFloat(2, 0, 20),
            'car_id' => Car::factory()->create(['user_id' => $this->user->id])->getKey()
        ];

        $response = $this->post(route('trip.store'), $newTrip);
        $response->assertRedirect(route('trip.index'));
        $this->assertDatabaseHas('trips', [
            'date' => Arr::get($newTrip, 'date'),
            'miles' => Arr::get($newTrip, 'miles'),
            'total' => Arr::get($trip, 'miles') + Arr::get($newTrip, 'miles'),
            'car_id' => Arr::get($newTrip, 'car_id'),
        ]);
    }

    public function testTripShow()
    {
        /** @var Trip $trip */
        $trip = Trip::factory()->create([
            'user_id' => $this->user->id,
            'car_id' => Car::factory()->create(['user_id' => $this->user->id])
        ]);
        $response = $this->get(route('trip.show', [$trip->id]));
        $response->assertInertia(
            fn (Assert $page) => $page
                ->component('Trip/View')
                ->has('trip')
        );
    }

    public function testTripDestroy()
    {
        /** @var Trip $trip */
        $trip = Trip::factory()->create([
            'user_id' => $this->user->id,
            'car_id' => Car::factory()->create(['user_id' => $this->user->id])
        ]);
        $response = $this->delete(route('trip.destroy', [$trip->id]));
        $response->assertRedirect(route('trip.index'));
        $this->assertDatabaseMissing('trips', [
            'id' => $trip->id
        ]);
    }
}
