<?php

namespace Tests\Feature\Wallet;

use App\Models\User;
use App\Models\UserWallet;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class UpdateWalletTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_try_to_update_wallets_belongs_to_user(): void
    {
        $user = User::factory()->create();
        $wallet = Wallet::factory()
            ->hasAttached($user)
            ->create();

        $response = $this
            ->actingAs($user)
            ->patch("/api/wallet/$wallet->id", [
                'active' => false,
                'name' => 'Renamed'
            ]);

        $response->assertStatus(204);
    }
}
