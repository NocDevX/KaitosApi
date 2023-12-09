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
     * @return JsonResponse
     */
    public function get(User $user): JsonResponse
    {
        return response()->json($user->wallets()->get());
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
            throw new Exception($e->getMessage());
        }

        return response()->json(['wallet' => $wallet], 201);
    }

    /**
     * @param Wallet $wallet
     * @param WalletService $service
     * @return JsonResponse
     * @throws Exception
     */
    public function update(Wallet $wallet, WalletService $service): JsonResponse
    {
        try {
            $walletWasDeactivated = $service->update($wallet);
        } catch (Throwable $e) {
            throw new Exception($e->getMessage());
        }

        return response()->json(['success' => $walletWasDeactivated], 204);
    }

    /**
     * @param Wallet $wallet
     * @param User $user
     * @param WalletService $service
     * @return JsonResponse
     * @throws Exception
     */
    public function delete(Wallet $wallet, User $user, WalletService $service): JsonResponse
    {
        try {
            $successful = $service->delete($wallet);
        } catch (Throwable $e) {
            throw new Exception($e->getMessage());
        }

        return response()->json(['successful' => $successful], 204);
    }
}
