<?php

namespace Tests\Feature;

use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PropertyTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
        $this->user = $this->authUser();
    }

    #[Test]
    public function it_can_list_properties()
    {
        Property::factory()->count(3)->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user, 'sanctum')->getJson('/api/properties');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    #[Test]
    public function it_can_create_a_property()
    {
        $data = [
            'title' => 'New Property',
            'description' => 'This is a new property.',
            'price' => '1.000.000'
        ];

        $response = $this->actingAs($this->user, 'sanctum')->postJson('/api/properties', $data);

        $response->assertStatus(201)
            ->assertJsonFragment(['title' => 'New Property']);

        $this->assertDatabaseHas('properties', ['title' => 'New Property']);
    }

    #[Test]
    public function it_can_show_a_property()
    {
        $property = Property::factory()->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user, 'sanctum')->getJson("/api/properties/{$property->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['title' => $property->title]);
    }

    #[Test]
    public function it_can_update_a_property()
    {
        $property = Property::factory()->create(['user_id' => $this->user->id]);

        $data = [
            'title' => 'Updated Property',
            'description' => 'This is an updated property.',
            'price' => '2.000.000'
        ];

        $response = $this->actingAs($this->user, 'sanctum')->putJson("/api/properties/{$property->id}", $data);

        $response->assertStatus(200)
            ->assertJsonFragment(['title' => 'Updated Property']);

        $this->assertDatabaseHas('properties', ['title' => 'Updated Property']);
    }

    #[Test]
    public function it_can_delete_a_property()
    {
        $property = Property::factory()->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user, 'sanctum')->deleteJson("/api/properties/{$property->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('properties', ['id' => $property->id]);
    }
}
