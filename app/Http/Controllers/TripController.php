<?php

namespace App\Http\Controllers;

use App\Http\Requests\TripStoreRequest;
use App\Http\Resources\TripResource;
use App\Models\Car;
use App\Models\Trip;
use App\Repositories\TripRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class TripController extends Controller
{
    public function __construct(protected TripRepository $tripRepository)
    {
    }

    /**
     * @throws AuthorizationException
     */
    public function index(): Response
    {
        $this->authorize('viewAll', [Trip::class]);

        return Inertia::render('Trip/Index', [
            'trips' => TripResource::collection(Trip::byUser(auth()->user())->orderByLatest()->get()),
        ]);
    }

    /**
     * @throws AuthorizationException
     */
    public function create(): Response
    {
        $this->authorize('view', [Trip::class]);

        return Inertia::render('Trip/Create', [
            'cars' => Car::byUser(auth()->user())->get()->map(function (Car $car) {
                return [
                    'id' => $car->id,
                    'name' => $car->name,
                ];
            }),
        ]);
    }

    /**
     * @throws AuthorizationException
     */
    public function show(Trip $trip): Response
    {
        $this->authorize('view', [Trip::class, $trip]);

        return Inertia::render('Trip/View', [
            'trip' => new TripResource($trip),
        ]);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(TripStoreRequest $request): RedirectResponse
    {
        $this->authorize('store', [Trip::class]);

        $this->tripRepository->addTrip([
            'date' => Carbon::parse($request->requestDate()),
            'miles' => $request->miles(),
            'car_id' => $request->carId(),
        ]);

        return Redirect::route('trip.index');
    }

    /**
     * @throws AuthorizationException
     * @throws Exception
     */
    public function destroy(Trip $trip): RedirectResponse
    {
        $this->authorize('delete', [Trip::class, $trip]);

        $this->tripRepository->removeTrip($trip);

        return Redirect::route('trip.index');
    }
}
