<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateWalletRequest;
use App\Models\User;
use App\Models\Wallet;
use App\Services\WalletService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Exception;

class WalletController extends Controller
{
    /**
     * @param User $user
     * @return Collection
     */
    public function get(User $user): Collection
    {
        return collect($user->load('wallets'));
    }

    /**
     * @param User $user
     * @param CreateWalletRequest $request
     * @param WalletService $service
     * @return mixed
     * @throws \Exception
     */
    public function create(User $user, CreateWalletRequest $request, WalletService $service): Wallet
    {
        DB::beginTransaction();
        try {
            $wallet = $service->save($user, $request);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception(trans('customexceptions.save_wallet'));
        }

        DB::commit();
        return $wallet;
    }

    /**
     * @param Wallet $wallet
     * @return void
     */
    public function deactivate(Wallet $wallet)
    {
        $wallet->active = false;
        $wallet->save();
    }

    /**
     * @param User $user
     * @param Wallet $wallet
     * @param WalletService $service
     * @return bool
     * @throws \Exception
     */
    public function delete(Wallet $wallet, User $user, WalletService $service): bool
    {
        DB::beginTransaction();
        try {
            $service->delete($user, $wallet);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception(__('customexceptions.delete_wallet'));
        }

        DB::commit();
        return true;
    }
}
