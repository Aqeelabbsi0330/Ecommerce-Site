<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlacklistedRefreshToken extends Model
{
    protected $fillable = [
        'jti',
        'blacklisted_at',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
