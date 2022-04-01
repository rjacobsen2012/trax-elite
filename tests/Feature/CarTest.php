<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\Trip;
use Illuminate\Support\Arr;
use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;

class CarTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->login();
    }

    public function testCarIndex()
    {
        Car::factory()->times(5)->create(['user_id' => $this->user->id]);
        $response = $this->get(route('car.index'));
        $response->assertInertia(
                fn (Assert $page) => $page
                    ->component('Car/Index')
                    ->has('cars')
            );
    }

    public function testCarCreate()
    {
        $this->get(route('car.create'))
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('Car/Create')
            );
    }

    public function testCarStore()
    {
        $car = [
            'model' => $this->faker->name,
        ];

        $response = $this->post(route('car.store'), $car);
        $response->assertStatus(302);
        $this->assertDatabaseMissing('cars', [
            'model' => Arr::get($car, 'model'),
        ]);

        $car['make'] = $this->faker->name;

        $response = $this->post(route('car.store'), $car);
        $response->assertStatus(302);
        $this->assertDatabaseMissing('cars', [
            'model' => Arr::get($car, 'model'),
            'make' => Arr::get($car, 'make'),
        ]);

        $car['year'] = $this->faker->year;

        $response = $this->post(route('car.store'), $car);
        $response->assertRedirect(route('car.index'));
        $this->assertDatabaseHas('cars', [
            'model' => Arr::get($car, 'model'),
            'make' => Arr::get($car, 'make'),
            'year' => Arr::get($car, 'year')
        ]);
    }

    public function testCarShow()
    {
        /** @var Car $car */
        $car = Car::factory()->create(['user_id' => $this->user->id]);
        $response = $this->get(route('car.show', [$car->id]));
        $response->assertInertia(
            fn (Assert $page) => $page
                ->component('Car/View')
                ->has('car')
        );
    }

    public function testCarDestroy()
    {
        /** @var Trip $trip */
        $trip = Trip::factory()->create([
            'user_id' => $this->user->id,
            'car_id' => Car::factory()->create(['user_id' => $this->user->id])
        ]);
        $car = $trip->car;

        $response = $this->delete(route('car.destroy', [$car->id]));
        $response->assertStatus(403);

        $trip->delete();
        $response = $this->delete(route('car.destroy', [$car->id]));
        $response->assertRedirect(route('car.index'));
        $this->assertDatabaseMissing('cars', [
            'id' => $car->id
        ]);
    }
}
