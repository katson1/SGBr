<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Place;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlaceControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_places()
    {
        Place::factory()->count(3)->create();

        $response = $this->getJson(route('places.index'));
        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    public function test_store_creates_a_place()
    {
        $data = [
            'name' => 'Airport',
            'slug' => 'cpv',
            'city' => 'Campina Grande',
            'state' => 'Paraiba',
        ];

        $response = $this->postJson(route('places.store'), $data);
        $response->assertStatus(201);

        $this->assertDatabaseHas('places', $data);
    }

    public function test_show_returns_a_place()
    {
        $place = Place::factory()->create();

        $response = $this->getJson(route('places.show', $place->id));
        $response->assertStatus(200);
        $response->assertJson([
            'id' => $place->id,
            'name' => $place->name,
            'slug' => $place->slug,
        ]);
    }

    public function test_update_modifies_a_place()
    {
        $place = Place::factory()->create();

        $data = [
            'name' => 'Airport',
        ];

        $response = $this->putJson(route('places.update', $place->id), $data);
        $response->assertStatus(200);

        $this->assertDatabaseHas('places', [
            'id' => $place->id,
            'name' => 'Airport',
        ]);
    }

    public function test_update_modifies_everything_of_a_place()
    {
        $place = Place::factory()->create();

        $data = [
            'name' => 'Airport JPA',
            'slug' => 'jpa',
            'city' => 'Joao Pessoa',
            'state' => 'Paraiba',
        ];

        $response = $this->putJson(route('places.update', $place->id), $data);
        $response->assertStatus(200);

        $this->assertDatabaseHas('places', [
            'name' => 'Airport JPA',
            'slug' => 'jpa',
            'city' => 'Joao Pessoa',
            'state' => 'Paraiba',
        ]);
    }

    public function test_destroy_deletes_a_place()
    {
        $place = Place::factory()->create();

        $response = $this->deleteJson(route('places.destroy', $place->id));
        $response->assertStatus(204);

        $this->assertDatabaseMissing('places', ['id' => $place->id]);
    }
}
