<?php

namespace App\Models;

use App\Models\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property $id
 * @property $name
 */
class Wallet extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function user(): BelongsToMany
    {
        return $this->belongsToMany(User::class, UserWallet::class);
    }
}
