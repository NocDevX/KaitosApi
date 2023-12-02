<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserWallet;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends Factory<UserWallet>
 */
class UserWalletFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition($uniqueCombinations = []): array
    {
        return [];
    }
}
