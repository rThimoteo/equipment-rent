<?php

namespace App\Rules;

use App\Models\Rental;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EquipmentAvailable implements ValidationRule
{
    protected $startDate;
    protected $endDate;
    protected $rental;

    public function __construct($startDate, $endDate, ?Rental $rental = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->rental = $rental;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $equipmentId = $this->rental?->equipment_id ?? $value;
        $ignoreId = $this->rental?->id;

        $exists = Rental::where('equipment_id', $equipmentId)
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->where(function ($q) {
                $q->whereBetween('start_date', [$this->startDate, $this->endDate])
                    ->orWhereBetween('end_date', [$this->startDate, $this->endDate])
                    ->orWhere(function ($q) {
                        $q->where('start_date', '<=', $this->startDate)
                            ->where('end_date', '>=', $this->endDate);
                    });
            })
            ->exists();

        if ($exists) {
            $fail('O equipamento já está alugado nesse período.');
        }
    }
}
