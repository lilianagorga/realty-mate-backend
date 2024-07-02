<?php

namespace Tests\Feature;

use App\Models\Price;
use App\Models\PriceFeature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PriceTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
        $this->user = $this->authUser();
    }

    #[Test]
    public function it_can_list_prices()
    {
        Price::factory()->count(3)->create();

        $response = $this->getJson('/api/prices');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    #[Test]
    public function it_can_create_a_price()
    {
        $data = [
            'plan' => 'New Plan',
            'price' => 99.99,
            'ptext' => 'per user, per month',
            'best' => 'Best Value'
        ];

        $response = $this->actingAs($this->user, 'sanctum')->postJson('/api/prices', $data);

        $response->assertStatus(201)
            ->assertJsonFragment(['plan' => 'New Plan']);

        $this->assertDatabaseHas('prices', ['plan' => 'New Plan']);
    }

    #[Test]
    public function it_can_show_a_price()
    {
        $price = Price::factory()->create();

        $response = $this->actingAs($this->user, 'sanctum')->getJson("/api/prices/{$price->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['plan' => $price->plan]);
    }

    #[Test]
    public function it_can_update_a_price()
    {
        $price = Price::factory()->create();

        $data = [
            'plan' => 'Updated Plan',
            'price' => 199.99,
            'ptext' => 'per user, per month',
            'best' => 'Best Value'
        ];

        $response = $this->actingAs($this->user, 'sanctum')->putJson("/api/prices/{$price->id}", $data);

        $response->assertStatus(200)
            ->assertJsonFragment(['plan' => 'Updated Plan']);

        $this->assertDatabaseHas('prices', ['plan' => 'Updated Plan']);
    }

    #[Test]
    public function it_can_delete_a_price()
    {
        $price = Price::factory()->create();

        $response = $this->actingAs($this->user, 'sanctum')->deleteJson("/api/prices/{$price->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('prices', ['id' => $price->id]);
    }
}
