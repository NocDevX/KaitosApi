<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property $user_id
 * @property $wallet_id
 */
class UserWallet extends Model
{
    use HasFactory;

    protected $table = 'user_wallet';
    protected $fillable = ['user_id', 'wallet_id'];
    public $timestamps = false;
    public $incrementing = false;
}
