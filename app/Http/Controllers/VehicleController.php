<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVehicleRequest;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Gate;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::where('user_id', auth()->id())->paginate(15);

        return view('vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        $vehicleMakes = json_decode(file_get_contents(storage_path('app/data/vehicle_makes.json')), true);

        return view('vehicles.create', compact('vehicleMakes'));
    }

    public function store(StoreVehicleRequest $request)
    {
        Vehicle::create($request->validated() + ['user_id' => auth()->user()->id]);

        return redirect()->route('vehicles.index')
            ->with('success', 'Vehicle created successfully.');
    }

    public function show(Vehicle $vehicle)
    {
        Gate::authorize('view', $vehicle);

        $vehicle->load([
            'incomes',
            'expenses',
        ]);

        $vehicle->total_income = $vehicle->incomes->sum('amount');
        $vehicle->total_expense = $vehicle->expenses->sum('amount');

        return view('vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        Gate::authorize('update', $vehicle);

        $vehicleMakes = json_decode(file_get_contents(storage_path('app/data/vehicle_makes.json')), true);

        return view('vehicles.edit', compact('vehicle', 'vehicleMakes'));
    }

    public function update(StoreVehicleRequest $request, Vehicle $vehicle)
    {
        Gate::authorize('update', $vehicle);

        $vehicle->update($request->validated());

        return redirect()->route('vehicles.show', $vehicle)
            ->with('success', 'Vehicle updated successfully.');
    }

    public function destroy(Vehicle $vehicle)
    {
        Gate::authorize('delete', $vehicle);

        $vehicle->delete();

        return redirect()->route('vehicles.index')
            ->with('success', 'Vehicle deleted successfully.');
    }
}
