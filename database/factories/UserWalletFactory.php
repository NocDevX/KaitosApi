<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserWallet;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

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
    public function definition(): array
    {
        return [
            'user_id' => function () {
                return User::query()->inRandomOrder()->first('id')->id;
            },
            'wallet_id' => function() {
                return Wallet::query()->inRandomOrder()->first()->id;
            }
        ];
    }
}
