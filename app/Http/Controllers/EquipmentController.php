<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEquipmentRequest;
use App\Http\Requests\UpdateEquipmentRequest;
use App\Models\Equipment;
use App\Repositories\EquipmentRepository;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function __construct(protected EquipmentRepository $equipmentRepository) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $name = $request->input('name');
        $selectedDate = $request->input('date') ?? now()->toDateString();
        $available = $request->input('available') ?? '1';

        $equipments = $this->equipmentRepository->getWithFilters($name, $available, $selectedDate);

        return view('equipments.index', compact('equipments', 'selectedDate', 'name', 'available'));
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
    public function store(StoreEquipmentRequest $request)
    {
        $data = $request->validated();

        Equipment::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'daily_value' => $data['daily_value'],
        ]);

        return redirect()->route('equipments.index')->with('success', 'Equipamento criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Equipment $equipment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Equipment $equipment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEquipmentRequest $request, Equipment $equipment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equipment $equipment)
    {
        //
    }

    public function available(Request $request)
    {
        $start = $request->input('start_date');
        $end = $request->input('end_date');

        if (!$start || !$end) {
            return response()->json([]);
        }

        $equipments = $this->equipmentRepository->availableBetween($start, $end);

        return response()->json($equipments);
    }
}
