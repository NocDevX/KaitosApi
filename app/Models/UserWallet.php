<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }
}
