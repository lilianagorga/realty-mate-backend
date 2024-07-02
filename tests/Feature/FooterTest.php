<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FooterTest extends TestCase
{
    #[Test]
    public function it_returns_footer_links()
    {

        $response = $this->getJson('/api/footer-links');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'services' => [
                    '*' => ['name', 'link']
                ],
                'about' => [
                    '*' => ['name', 'link']
                ],
                'workWithUs' => [
                    '*' => ['name', 'link']
                ],
                'ourOffices' => [
                    '*' => ['name', 'link']
                ],
            ]);
    }
}
