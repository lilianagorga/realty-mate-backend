<?php

namespace Tests\Feature;

use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TeamTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
        $this->user = $this->authUser();
    }

    #[Test]
    public function it_can_list_teams()
    {
        Team::factory()->count(3)->create();

        $response = $this->getJson('/api/teams');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    #[Test]
    public function it_can_create_a_team()
    {
        $data = [
            'name' => 'New Team',
            'address' => '123 Street',
            'list' => 1,
            'cover' => '/images/customer/team-new.jpg',
            'icon' => json_encode([
                '<i class="fa-brands fa-facebook-f"></i>',
                '<i class="fa-brands fa-linkedin"></i>',
                '<i class="fa-brands fa-twitter"></i>',
                '<i class="fa-brands fa-instagram"></i>'
            ])
        ];

        $response = $this->actingAs($this->user, 'sanctum')->postJson('/api/teams', $data);

        $response->assertStatus(201)
            ->assertJsonFragment(['name' => 'New Team']);

        $this->assertDatabaseHas('teams', ['name' => 'New Team']);
    }

    #[Test]
    public function it_can_show_a_team()
    {
        $team = Team::factory()->create();

        $response = $this->actingAs($this->user, 'sanctum')->getJson("/api/teams/{$team->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $team->name]);
    }

    #[Test]
    public function it_can_update_a_team()
    {
        $team = Team::factory()->create();

        $data = [
            'name' => 'Updated Team',
            'address' => '456 Avenue',
            'list' => 2,
            'cover' => '/images/customer/team-updated.jpg',
            'icon' => json_encode([
                '<i class="fa-brands fa-facebook-f"></i>',
                '<i class="fa-brands fa-linkedin"></i>',
                '<i class="fa-brands fa-twitter"></i>',
                '<i class="fa-brands fa-instagram"></i>'
            ])
        ];

        $response = $this->actingAs($this->user, 'sanctum')->putJson("/api/teams/{$team->id}", $data);

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Updated Team']);

        $this->assertDatabaseHas('teams', ['name' => 'Updated Team']);
    }

    #[Test]
    public function it_can_delete_a_team()
    {
        $team = Team::factory()->create();

        $response = $this->actingAs($this->user, 'sanctum')->deleteJson("/api/teams/{$team->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('teams', ['id' => $team->id]);
    }
}
