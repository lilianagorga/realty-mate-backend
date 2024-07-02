<?php

namespace Tests\Feature;

use App\Models\Partner;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PartnerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
        $this->user = $this->authUser();
    }

    #[Test]
    public function it_can_list_partners()
    {
        $partners = Partner::factory()->count(3)->create();

        $response = $this->getJson('/api/partners');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    #[Test]
    public function it_can_create_a_partner()
    {
        $data = [
            'name' => 'New Partner',
            'logo' => '/images/partners/new_partner.png'
        ];

        $response = $this->actingAs($this->user, 'sanctum')->postJson('/api/partners', $data);

        $response->assertStatus(201)
            ->assertJsonFragment(['name' => 'New Partner']);

        $this->assertDatabaseHas('partners', ['name' => 'New Partner']);
    }

    #[Test]
    public function it_can_show_a_partner()
    {
        $partner = Partner::factory()->create();

        $response = $this->actingAs($this->user, 'sanctum')->getJson("/api/partners/{$partner->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $partner->name]);
    }

    #[Test]
    public function it_can_update_a_partner()
    {
        $partner = Partner::factory()->create();

        $data = [
            'name' => 'Updated Partner',
            'logo' => '/images/partners/updated_partner.png'
        ];

        $response = $this->actingAs($this->user, 'sanctum')->putJson("/api/partners/{$partner->id}", $data);

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Updated Partner']);

        $this->assertDatabaseHas('partners', ['name' => 'Updated Partner']);
    }

    #[Test]
    public function it_can_delete_a_partner()
    {
        $partner = Partner::factory()->create();

        $response = $this->actingAs($this->user, 'sanctum')->deleteJson("/api/partners/{$partner->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('partners', ['id' => $partner->id]);
    }
}
