<?php

namespace App\Repositories;

use App\Models\Equipment;
use Illuminate\Support\Carbon;

class EquipmentRepository
{
    public function getWithFilters(?string $name, ?string $available, string $date)
    {
        $equipments = Equipment::with(['rentals' => function ($query) use ($date) {
            $query->whereDate('start_date', '<=', $date)
                ->whereDate('end_date', '>=', $date);
        }]);

        if ($name) {
            $equipments->where('name', 'like', '%' . $name . '%');
        }

        $equipments = $equipments->get()->map(function ($equipment) use ($available) {
            $rental = $equipment->rentals->first();
            $isAvailable = !$rental;

            $equipment->is_available = $isAvailable;
            $equipment->unavailable_until = $rental ? \Carbon\Carbon::parse($rental->end_date)->format('d/m/Y') : null;

            if ($available === '0' && $isAvailable) {
                return null;
            }

            return $available === '0' || $isAvailable ? $equipment : null;
        })->filter();

        return $equipments->values();
    }

    public function availableBetween($start, $end)
    {
        return Equipment::whereDoesntHave('rentals', function ($query) use ($start, $end) {
            $query->where(function ($q) use ($start, $end) {
                $q->whereBetween('start_date', [$start, $end])
                    ->orWhereBetween('end_date', [$start, $end])
                    ->orWhere(function ($q2) use ($start, $end) {
                        $q2->where('start_date', '<=', $start)
                            ->where('end_date', '>=', $end);
                    });
            });
        })->get(['id', 'name']);
    }
}
