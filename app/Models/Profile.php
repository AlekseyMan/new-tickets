<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Profile extends Model
{
    use HasFactory;

    CONST ROLE_KARATEKA = "karateka";
    CONST ROLE_PARENT = "parent";
    CONST ROLE_COACH = "coach";

    protected $fillable = [
        'name',
        'surname',
        'patronymic',
        'qu',
        'dan',
        'birthday',
        'weight',
        'coach_id',
        'profile_role'
    ];

    public function user(): HasOne
    {
        return $this->hasOne('users', 'id', 'user_id');
    }

    public function balance(): HasOne
    {
        return $this->hasOne('balances', 'profile_id', 'id');
    }

    public function getFullNameAttribute(): string
    {
        return $this->surname . " " . $this->name . " " . $this->patronymic;
    }
}
