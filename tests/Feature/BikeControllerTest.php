<?php

namespace Tests\Feature;

use App\Models\Bike;
use Tests\TestCase;

class BikeControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->app['config']->set('database.default', 'sqlite');
    }

    /** @test */
    public function can_get_all_bikes()
    {
        $bikes = Bike::factory()->count(5)->create();

        $response = $this->getJson('/api/bikes');

        $response->assertOk();
        $response->assertJsonCount(5);
    }

    /** @test */
    public function can_create_a_bike()
    {
        $bikeData = [
            'title' => 'Bike 1',
            'content' => 'text text text',
        ];

        $response = $this->postJson('/api/bikes', $bikeData);

        $response->assertStatus(201);
        $response->assertJsonFragment($bikeData);
    }

    /** @test */
    public function can_get_a_bike()
    {
        $bike = Bike::factory()->create();

        $response = $this->getJson('/api/bikes/'.$bike->id);

        $response->assertOk();
        $response->assertJsonFragment($bike->toArray());
    }

    /** @test */
    public function can_update_a_bike()
    {
        $bike = Bike::factory()->create();

        $updatedBikeData = [
            'title' => 'Updated Bike 1',
            'content' => 'Updated text text text',
        ];

        $response = $this->putJson('/api/bikes/'.$bike->id, $updatedBikeData);

        $response->assertOk();
        $this->assertDatabaseHas('bikes', $updatedBikeData);
        $response->assertJsonFragment($updatedBikeData);
    }

    /** @test */
    public function can_delete_a_bike()
    {
        $bike = Bike::factory()->create();

        $response = $this->deleteJson('/api/bikes/'.$bike->id);

        $response->assertNoContent();
        $this->assertModelMissing($bike);
    }
}
