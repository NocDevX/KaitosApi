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
        $user = $user->load('wallets');
        dump($user);
    }
}
