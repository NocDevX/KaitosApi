<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Wallet>
 */
class WalletFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $oldestUser = User::query()->orderBy('created_at')->first('created_at');
        $createdAt = fake()->dateTimeBetween($oldestUser->created_at);

        return [
            'name' => mb_substr(fake()->company(), 0, 64),
            'created_at' => $createdAt,
            'updated_at' => fake()->dateTimeBetween($createdAt)
        ];
    }
}
