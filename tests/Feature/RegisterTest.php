<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function testAUserCanRegister()
    {
        $this->postJson('/api/user/register',
            ['name' => 'Liliana', 'email' => 'test@test.it', 'password' => 'Secret123!', 'password_confirmation' => 'Secret123!' ])
            ->assertCreated();
        $this->assertDatabaseHas('users', ['name' => 'Liliana']);
    }
}
