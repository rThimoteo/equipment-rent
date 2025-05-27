<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRentalRequest;
use App\Http\Requests\UpdateRentalRequest;
use App\Models\Equipment;
use App\Models\Rental;
use App\Repositories\RentalRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    public function __construct(protected RentalRepository $rentalRepository) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rentals = $this->rentalRepository->getAllRentals();

        $equipments = Equipment::all();
        return view('rentals.index', compact('rentals', 'equipments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRentalRequest $request)
    {
        $validated = $request->validated();

        $totalValue = Equipment::findOrFail($validated['equipment_id'])
            ->calculate($validated['start_date'], $validated['end_date']);

        Rental::create([
            'equipment_id' => $validated['equipment_id'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'value' => $totalValue,
        ]);

        return redirect()->route('rentals.index');
    }
    /**
     * Display the specified resource.
     */
    public function show(Rental $rental)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rental $rental)
    {
        return view('rentals.edit', compact('rental'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRentalRequest $request, Rental $rental)
    {
        $validated = $request->validated();

        $rental->loadMissing('equipment');

        $value = $rental->equipment->calculate($validated['start_date'], $validated['end_date']);

        $rental->update([
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'value' => $value,
        ]);

        return redirect()->route('rentals.index')->with('success', 'Locação atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $rental = Rental::findOrFail($id);
        $rental->delete();

        return redirect()->route('rentals.index');
    }
}
