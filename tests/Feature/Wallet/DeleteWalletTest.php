<?php

namespace Tests\Feature\Wallet;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class DeleteWalletTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_try_to_get_user_wallets(): void
    {
        $user = User::factory()->create();
        $wallet = Wallet::factory()
            ->hasAttached($user)
            ->create();

        $response = $this
            ->actingAs($user)
            ->delete("/api/wallet/$wallet->id");

        $response->assertStatus(204);
    }
}
