<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'contacts',
        'description'
    ];

    public function groups(): HasMany
    {
        return $this->hasMany('groups', 'school_id', 'id');
    }
}
