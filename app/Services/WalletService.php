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
     * @param Wallet $wallet
     * @return bool
     * @throws Exception
     */
    public function delete(Wallet $wallet): bool
    {
        if (!$this->belongsToUser($wallet->id)) {
            throw new Exception(__('customexceptions.permission_denied_wallet'));
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
    public function update(Wallet $wallet): bool
    {
        if (!$this->belongsToUser($wallet->id)) {
            throw new Exception(__('customexceptions.permission_denied_wallet'));
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
