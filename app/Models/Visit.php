<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'coach_id',
        'visited',
        'updated_at',
        'date'
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo('tickets', 'id', 'ticket_id');
    }

    public function addVisitToTable($data)
    {
        $data['coach_id'] = Auth::id();
        $data['date'] = today();
        $this->updateOrCreate(
            [
                'date' => today()
            ],
            $data);
        $ticket = Ticket::find($data['ticket_id']);
        return response()->json([
            'is_closed' => $ticket->isClosed(),
            'visits_number' => $ticket->visitsNumber
        ]);
    }

    public function scopeVisited($query)
    {
        return $query->where('visited', 1);
    }
}
