<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Equipment;
use App\Models\Rental;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EquipmentControllerTest extends TestCase
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

    /** @test */
    public function it_can_create_an_equipment()
    {
        $equipment = Equipment::create([
            'name' => 'Gerador',
            'description' => 'Gerador de energia portátil',
            'daily_value' => 150.00,
        ]);

        $this->assertDatabaseHas('equipments', ['name' => 'Gerador']);
    }

    /** @test */
    public function it_lists_equipments()
    {
        Equipment::factory()->count(3)->create();

        $response = $this->get('/equipments');
        $response->assertStatus(200);
        $response->assertSeeText('Equipamentos');
    }

    /** @test */
    public function it_filters_available_equipments_by_date()
    {
        $missingEquipment = Equipment::factory()->create();
        $equipment = Equipment::factory()->create();

        Rental::create([
            'equipment_id' => $missingEquipment->id,
            'start_date' => now()->addDays(2),
            'end_date' => now()->addDays(5),
            'value' => 500.00,
        ]);

        $response = $this->getJson('/equipments/available?start_date=' . now()->addDays(1)->toDateString() . '&end_date=' . now()->addDays(6)->toDateString());
        $response->assertStatus(200);
        $response->assertJsonMissing(['id' => $missingEquipment->id]);
        $response->assertJsonFragment(['id' => $equipment->id]);
    }
}
