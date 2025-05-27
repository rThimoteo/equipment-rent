<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Equipment;
use App\Models\Rental;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class RentalControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    #[Test]
    public function it_creates_a_rental()
    {
        $equipment = Equipment::factory()->create(['daily_value' => 100]);

        $response = $this->post('/rentals', [
            'equipment_id' => $equipment->id,
            'start_date' => now()->toDateString(),
            'end_date' => now()->addDays(3)->toDateString(),
        ]);

        $response->assertRedirect('/rentals');
        $this->assertDatabaseHas('rentals', ['equipment_id' => $equipment->id]);
    }

    #[Test]
    public function it_lists_rentals()
    {
        Rental::factory()->count(2)->create();

        $response = $this->get('/rentals');
        $response->assertStatus(200);
    }

    #[Test]
    public function it_edits_a_rental()
    {
        $rental = Rental::factory()->create([
            'start_date' => now()->toDateString(),
            'end_date' => now()->addDays(2)->toDateString(),
        ]);

        $response = $this->put(route('rentals.update', $rental), [
            'start_date' => now()->addDays(1)->toDateString(),
            'end_date' => now()->addDays(3)->toDateString(),
        ]);

        $response->assertRedirect('/rentals');
        $this->assertDatabaseHas('rentals', [
            'id' => $rental->id,
            'start_date' => now()->addDays(1)->toDateString(),
        ]);
    }

    #[Test]
    public function it_cancels_a_rental()
    {
        $rental = Rental::factory()->create();

        $response = $this->delete(route('rentals.destroy', $rental));

        $response->assertRedirect('/rentals');
        $this->assertDatabaseMissing('rentals', ['id' => $rental->id]);
    }
}
