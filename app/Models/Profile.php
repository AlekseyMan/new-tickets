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

    public function scopeKarateki($query)
    {
        return $query->where('profile_role', self::ROLE_KARATEKA);
    }

    public function scopeCoaches($query)
    {
        return $query->where('profile_role', self::ROLE_COACH);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getTicketAttribute()
    {
        return Ticket::where('profile_id', $this->id)->latest('id')->first();
    }

    public function getFullNameAttribute(): string
    {
        return $this->surname . " " . $this->name . " " . $this->patronymic;
    }

}
