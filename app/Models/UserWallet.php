<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Thiagoprz\CompositeKey\HasCompositeKey;

class UserWallet extends Model
{
    use HasCompositeKey;
    use HasFactory;
    protected $primaryKey = ['user_id', 'wallet_id'];
    protected $fillable = ['user_id', 'wallet_id'];
}
