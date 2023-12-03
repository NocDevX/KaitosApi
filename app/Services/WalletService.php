<?php

namespace App\Services;

use App\Http\Requests\CreateWalletRequest;
use App\Models\User;
use App\Models\UserWallet;
use App\Models\Wallet;

class WalletService
{
    /**
     * @param Wallet $wallet
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

    /**
     * @param User $user
     * @param Wallet $wallet
     * @return bool
     */
    public function delete(User $user, Wallet $wallet): bool
    {
        $userWallets = new UserWallet();
        $userWallets = $userWallets->where([
            'wallet_id' => $wallet->id
        ])->with('wallet')->get();

        foreach ($userWallets as $userWallet) {
            $userWallet->where(['wallet_id' => $userWallet->wallet_id])->delete();
        }

        $wallet->delete();

        return true;
    }
}
