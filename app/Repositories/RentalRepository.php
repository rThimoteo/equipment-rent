<?php

namespace App\Repositories;

use App\Models\Equipment;
use App\Models\Rental;
use Carbon\Carbon;

class RentalRepository
{
    public function getAllRentals()
    {
        return Rental::with('equipment')->get(); 
    }
}
