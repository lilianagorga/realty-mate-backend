<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_check_if_post_route_exists(): void
    {
        $user = $this->authUser();
        $this->assertEquals('realty_mate_testing', config('database.connections.mysql.database'));
        $response = $this->actingAs($user)->post('/api/logout');
        $response->assertOk();
    }

    public function test_user_can_logout()
    {

        /** @var User $user */
        $user = $this->createUser();

        $this->assertNotNull($user);
        $token = $user->createToken('main')->plainTextToken;

        Log::Info("User ID  : " . $user->id);

        Log::Info("first log testing token :" . $token);

        $tokenId = (int)explode('|', $token, 2)[0];

        Log::Info("second log testing token id :" . $tokenId);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/logout');

        $response->assertOk()->assertJson(['success' => true]);
        $this->assertDatabaseMissing('personal_access_tokens', [
            'id' => $tokenId,
        ]);
    }
}
