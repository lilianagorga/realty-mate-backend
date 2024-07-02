<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    public function createUser($args = [])
    {
        return User::factory()->create($args);
    }

    public function createUserCount($count = 5)
    {
        return User::factory()->count($count)->create();
    }

    public function authUser()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        return $user;
    }
}
