<?php

namespace Tests\Feature\Wallet;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class GetWalletTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_try_to_get_user_wallets(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get("/api/wallets/1");

        $response->assertStatus(200);
    }
}
