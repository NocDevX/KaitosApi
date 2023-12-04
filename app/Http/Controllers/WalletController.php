<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateWalletRequest;
use App\Models\User;
use App\Models\Wallet;
use App\Services\WalletService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

class WalletController extends Controller
{
    /**
     * @param User $user
     * @return Collection
     */
    public function get(User $user): JsonResponse
    {
        return response()->json([
            'wallets' => $user->wallets()->get()
        ]);
    }

    /**
     * @param User $user
     * @param CreateWalletRequest $request
     * @param WalletService $service
     * @return mixed
     * @throws Exception
     */
    public function create(User $user, CreateWalletRequest $request, WalletService $service): JsonResponse
    {
        try {
            $wallet = $service->save($user, $request);
        } catch (Throwable $e) {
            throw new Exception(__('customexceptions.save_wallet'));
        }

        return response()->json(['wallet' => $wallet]);
    }

    /**
     * @param Wallet $wallet
     * @param WalletService $service
     * @return JsonResponse
     * @throws Exception
     */
    public function deactivate(Wallet $wallet, WalletService $service): JsonResponse
    {
        try {
            $walletWasDeactivated = $service->deactivate($wallet);
        } catch (Throwable $e) {
            throw new Exception(__('customexceptions.deactivate_wallet'));
        }

        return response()->json(['success' => $walletWasDeactivated]);
    }

    /**
     * @param User $user
     * @param Wallet $wallet
     * @param WalletService $service
     * @return bool
     * @throws Exception
     */
    public function delete(Wallet $wallet, User $user, WalletService $service): JsonResponse
    {
        try {
            $successful = $service->delete($user, $wallet);
        } catch (Throwable $e) {
            throw new Exception(__('customexceptions.delete_wallet'));
        }

        return response()->json(['successful' => $successful]);
    }
}
