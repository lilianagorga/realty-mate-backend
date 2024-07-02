<?php

namespace Tests\Feature;

use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TestimonialTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
        $this->user = $this->authUser();
    }

    #[Test]
    public function it_can_list_testimonials()
    {
        Testimonial::factory()->count(3)->create();

        $response = $this->getJson('/api/testimonials');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    #[Test]
    public function it_can_create_a_testimonial()
    {
        $data = [
            'name' => 'New Testimonial',
            'company' => 'New Company',
            'testimonial' => 'This is a new testimonial.',
            'image' => '/images/testimonials/testimonial1.jpg'
        ];

        $response = $this->actingAs($this->user, 'sanctum')->postJson('/api/testimonials', $data);

        $response->assertStatus(201)
            ->assertJsonFragment(['name' => 'New Testimonial']);

        $this->assertDatabaseHas('testimonials', ['name' => 'New Testimonial']);
    }

    #[Test]
    public function it_can_show_a_testimonial()
    {
        $testimonial = Testimonial::factory()->create();

        $response = $this->actingAs($this->user, 'sanctum')->getJson("/api/testimonials/{$testimonial->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $testimonial->name]);
    }

    #[Test]
    public function it_can_update_a_testimonial()
    {
        $testimonial = Testimonial::factory()->create();

        $data = [
            'name' => 'Updated Testimonial',
            'company' => 'Updated Company',
            'testimonial' => 'This is an updated testimonial.',
            'image' => '/images/testimonials/testimonial2.jpg'
        ];

        $response = $this->actingAs($this->user, 'sanctum')->putJson("/api/testimonials/{$testimonial->id}", $data);

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Updated Testimonial']);

        $this->assertDatabaseHas('testimonials', ['name' => 'Updated Testimonial']);
    }

    #[Test]
    public function it_can_delete_a_testimonial()
    {
        $testimonial = Testimonial::factory()->create();

        $response = $this->actingAs($this->user, 'sanctum')->deleteJson("/api/testimonials/{$testimonial->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('testimonials', ['id' => $testimonial->id]);
    }
}
