<?php

namespace App\Services;

use App\Http\Requests\CreateWalletRequest;
use App\Models\User;
use App\Models\UserWallet;
use App\Models\Wallet;
use Exception;
use Illuminate\Support\Facades\DB;
use Throwable;

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
        DB::transaction(function () use ($user, $request, $wallet) {
            $wallet->name = $request->get('name');
            $wallet->save();

            $userWallet = new UserWallet();
            $userWallet->user_id = $user->id;
            $userWallet->wallet_id = $wallet->id;
            $userWallet->save();
        });

        return $wallet;
    }

    /**
     * @param User $user
     * @param Wallet $wallet
     * @return bool
     * @throws Throwable
     */
    public function delete(User $user, Wallet $wallet): bool
    {
        if (!$this->belongsToUser($wallet->id)) {
            return false;
        }

        DB::transaction(function () use ($wallet) {
            UserWallet::query()
                ->where('wallet_id', '=', $wallet->id)
                ->delete();

            $wallet->delete();
        });

        return true;
    }

    /**
     * @throws Exception
     * @throws Throwable
     */
    public function deactivate(Wallet $wallet): bool
    {
        if (!$this->belongsToUser($wallet->id)) {
            return false;
        }

        $wallet->active = false;
        return $wallet->saveOrFail();
    }

    /**
     * @param int $walletId
     * @return bool
     */
    public function belongsToUser(int $walletId): bool
    {
        return UserWallet::query()->where([
            ['user_id', '=', auth()->id()],
            ['wallet_id', '=', $walletId],
        ])->exists();
    }
}
