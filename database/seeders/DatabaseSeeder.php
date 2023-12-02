<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserWallet;
use Database\Seeders;
use App\Models\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
        $this->seedWalletUser();
    }

    public function seedWalletUser(): void
    {
        $uniqueCombos = DB::select(<<<SQL
            SELECT DISTINCT
                users.id AS user_id,
                wallets.id AS wallet_id
            FROM users
                JOIN wallets ON true
                WHERE NOT EXISTS (
                    SELECT 1 FROM user_wallets WHERE user_id = users.id AND wallet_id = wallets.id
                   )
            ORDER BY 1, 2
        SQL
        );

        foreach ($uniqueCombos as $combo) {
            UserWallet::factory()->create([
                'user_id' => $combo->user_id,
                'wallet_id' => $combo->wallet_id
            ]);
        }
    }
}
