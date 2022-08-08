<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'coach_id',
        'visited',
        'updated_at'
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo('tickets', 'id', 'ticket_id');
    }
}
