<?php

namespace Database\Seeders;

use App\Models\Equipment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $equipments = Equipment::factory(10)->create();

        foreach ($equipments as $equipment) {
            $equipment->rentals()->create([
                'start_date' => now(),
                'end_date' => now()->addDays(5),
                'value' => $equipment->calculate(now(), now()->addDays(5)),
            ]);
        }

        Equipment::factory(10)->create();
    }
}
