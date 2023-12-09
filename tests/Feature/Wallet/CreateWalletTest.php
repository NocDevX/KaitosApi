<?php

namespace Tests\Feature\Wallet;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class CreateWalletTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_try_to_create_wallet(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post("/api/wallet/$user->id", [
            'name' => 'Wallet ' . fake()->randomDigit(),
        ]);

        $response->assertStatus(201);
    }
}
