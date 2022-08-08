<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Balance extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'current_balance'
    ];

    public function profile(): BelongsTo
    {
        return $this->belongsTo('profiles', 'id', 'profile_id');
    }
}
