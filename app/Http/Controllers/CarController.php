<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarStoreRequest;
use App\Http\Resources\CarResource;
use App\Http\Resources\CarWithDetailsResource;
use App\Models\Car;
use App\Repositories\CarRepository;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class CarController extends Controller
{
    public function __construct(protected CarRepository $carRepository)
    {
    }

    /**
     * @throws AuthorizationException
     */
    public function index(): Response
    {
        $this->authorize('viewAll', [Car::class]);

        return Inertia::render('Car/Index', [
            'cars' => CarResource::collection(Car::byUser(auth()->user())->get()),
        ]);
    }

    /**
     * @throws AuthorizationException
     */
    public function create(): Response
    {
        $this->authorize('view', [Car::class]);

        return Inertia::render('Car/Create');
    }

    /**
     * @throws AuthorizationException
     */
    public function show(Car $car): Response
    {
        $this->authorize('view', [Car::class, $car]);

        return Inertia::render('Car/View', [
            'car' => new CarWithDetailsResource($car),
            'hasTrips' => $car->trips->count() > 0,
        ]);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(CarStoreRequest $request): RedirectResponse
    {
        $this->authorize('store', [Car::class]);

        $this->carRepository->addCar([
            'make' => $request->make(),
            'model' => $request->model(),
            'year' => $request->year(),
        ]);

        return Redirect::route('car.index');
    }

    /**
     * @throws AuthorizationException
     * @throws Exception
     */
    public function destroy(Car $car): RedirectResponse
    {
        $this->authorize('delete', [Car::class, $car]);

        $this->carRepository->removeCar($car);

        return Redirect::route('car.index');
    }
}
