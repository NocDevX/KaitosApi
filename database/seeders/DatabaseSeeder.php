<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserWallet;
use App\Models\Wallet;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        User::factory()->count(10)->create();
        Wallet::factory()->count(100)->create();
        UserWallet::factory()
            ->count(fake()->numberBetween(100, 1000))
            ->create();
    }
}
