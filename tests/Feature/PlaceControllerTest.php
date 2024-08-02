<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Place;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlaceControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_route_returns_places()
    {
        Place::factory()->count(5)->create();

        $response = $this->getJson(route('places.index'));
        $response->assertStatus(200);
        $response->assertJsonCount(5);
        $response->assertHeader('Content-Type', 'application/json');
    }

    public function test_store_route_creates_place()
    {
        $data = [
            'name' => 'Airport',
            'slug' => 'cpv',
            'city' => 'Campina Grande',
            'state' => 'Paraiba',
        ];

        $response = $this->postJson(route('places.store'), $data);
        $response->assertStatus(201);
        $response->assertHeader('Content-Type', 'application/json');

        $this->assertDatabaseHas('places', $data);
    }

    public function test_show_route_returns_place()
    {
        $place = Place::factory()->create();

        $response = $this->getJson(route('places.show', $place->id));
        $response->assertStatus(200);
        $response->assertJson([
            'id' => $place->id,
            'name' => $place->name,
            'slug' => $place->slug,
            'city' => $place->city,
            'state' => $place->state,
        ]);
        $response->assertHeader('Content-Type', 'application/json');
    }

    public function test_update_route_modifies_place()
    {
        $place = Place::factory()->create([
            'name' => 'Campina',
        ]);

        $data = [
            'name' => 'Campina Grande',
        ];

        $response = $this->putJson(route('places.update', $place->id), $data);
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');

        $this->assertDatabaseHas('places', [
            'id' => $place->id,
            'name' => 'Campina Grande',
        ]);
    }
    
    public function test_update_route_modifies_everything_of_a_place()
    {
        $place = Place::factory()->create([
            'name' => 'Airport',
            'slug' => 'cpv',
            'city' => 'Campina',
            'state' => 'Paraibo',
        ]);

        $data = [
            'name' => 'Airport',
            'slug' => 'cpv',
            'city' => 'Campina Grande',
            'state' => 'Paraiba',
        ];

        $response = $this->putJson(route('places.update', $place->id), $data);
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');

        $this->assertDatabaseHas('places', [
            'id' => $place->id,
            'name' => 'Airport',
            'slug' => 'cpv',
            'city' => 'Campina Grande',
            'state' => 'Paraiba',
        ]);
    }

    public function test_destroy_route_deletes_place()
    {
        $place = Place::factory()->create();

        $response = $this->deleteJson(route('places.destroy', $place->id));
        $response->assertStatus(204);

        $this->assertDatabaseMissing('places', ['id' => $place->id]);
    }

    public function test_store_route_creates_place_and_checks_count()
    {
        $initialCount = Place::count();

        $data = [
            'name' => 'airport',
            'slug' => 'cpv',
            'city' => 'Campina Grande',
            'state' => 'Paraiba',
        ];

        $response = $this->postJson(route('places.store'), $data);
        $response->assertHeader('Content-Type', 'application/json');
        $this->assertEquals($initialCount + 1, Place::count());
    }

    public function test_destroy_route_deletes_place_and_checks_count()
    {
        $place = Place::factory()->create();
        $initialCount = Place::count();

        $response = $this->deleteJson(route('places.destroy', $place->id));
        $this->assertEquals($initialCount - 1, Place::count());
    }

    public function test_index_route_returns_empty_when_no_places_exist()
    {
        $response = $this->getJson(route('places.index'));
        $response->assertStatus(200);
        $response->assertJsonCount(0);
        $response->assertHeader('Content-Type', 'application/json');
    }

    public function test_store_route_fails_with_missing_fields()
    {
        $data = [
            'name' => 'Airport',
        ];

        $response = $this->postJson(route('places.store'), $data);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['slug', 'city', 'state']);
        $response->assertHeader('Content-Type', 'application/json');
    }

    public function test_store_route_fails_with_long_name()
    {
        $data = [
            'name' => str_repeat('a', 256),
            'slug' => 'long-name',
            'city' => 'Campina Grande',
            'state' => 'Paraiba',
        ];

        $response = $this->postJson(route('places.store'), $data);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
        $response->assertHeader('Content-Type', 'application/json');
    }

    public function test_show_route_fails_with_invalid_id()
    {
        $response = $this->getJson(route('places.show', 99999));
        $response->assertStatus(404);
        $response->assertHeader('Content-Type', 'application/json');
    }

    public function test_update_route_fails_with_invalid_data()
    {
        $place = Place::factory()->create();

        $data = [
            'name' => '',
        ];

        $response = $this->putJson(route('places.update', $place->id), $data);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
        $response->assertHeader('Content-Type', 'application/json');
    }

    public function test_destroy_route_fails_with_invalid_id()
    {
        $response = $this->deleteJson(route('places.destroy', 99999));
        $response->assertStatus(404);
        $response->assertHeader('Content-Type', 'application/json');
    }

    public function test_update_route_partially_updates_place()
    {
        $place = Place::factory()->create([
            'name' => 'Airport',
            'city' => 'Joao Pessoa',
        ]);

        $data = [
            'city' => 'Campina Grande',
        ];

        $response = $this->putJson(route('places.update', $place->id), $data);
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/json');

        $this->assertDatabaseHas('places', [
            'id' => $place->id,
            'name' => 'Airport',
            'city' => 'Campina Grande',
        ]);
    }

    public function test_destroy_route_does_not_delete_non_existing_place()
    {
        $response = $this->deleteJson(route('places.destroy', 99999));
        $response->assertStatus(404);
        $response->assertHeader('Content-Type', 'application/json');
    }
}
