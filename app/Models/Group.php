<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'coach__id',
        'name',
        'times',
        'temporary_info',

    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo('schools', 'id', 'school_id');
    }

    public function karateki(): HasMany
    {
        return $this->hasMany('groups_profiles')->where('role', Profile::ROLE_KARATEKA);
    }
}
