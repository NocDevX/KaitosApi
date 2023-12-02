<?php

namespace App\Services;

use App\Http\Requests\CreateWalletRequest;
use App\Models\User;
use App\Models\UserWallet;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;

class WalletService
{
    /**
     * @param User $user
     * @param CreateWalletRequest $request
     * @return Wallet
     */
    public function save(User $user, CreateWalletRequest $request): Wallet
    {
        $wallet = new Wallet();
        $wallet->name = $request->get('name');
        $wallet->save();

        $userWallet = new UserWallet();
        $userWallet->user_id = $user->id;
        $userWallet->wallet_id = $wallet->id;
        $userWallet->save();

        return $wallet;
    }

    public function delete(User $user, Wallet $wallet)
    {
        $userWallet = new UserWallet();
        $userWallet->where([
            'user_id' => $user->id,
            'wallet_id' => $wallet->id
        ])->get();
    }
}
