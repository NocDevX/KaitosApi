<?php

namespace App\Http\Controllers;

use App\Models\User;

class WalletController extends Controller
{
    public function create()
    {
    }

    public function get(User $user)
    {
        $wallets = $user->wallets();
        dump($wallets);
    }
}
