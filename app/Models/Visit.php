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
        return $this->belongsTo(Ticket::class, 'id', 'ticket_id');
    }

    public function addVisitToTable($data)
    {
        isset($data['return_json']) ? $isReturnJson = 1 : $isReturnJson = 0;
        unset($data['return_json']);
        $data['coach_id'] = Profile::where('user_id', Auth::id())->first()->id;
        isset($data['date']) ?: today()->format("Y-m-d");
        $this->updateOrCreate(
            [
                'date' => $data['date'],
                'ticket_id' => $data['ticket_id']
            ],
            $data);
        $ticket = Ticket::find($data['ticket_id']);
        if($isReturnJson)
        {
            return response()->json([
                'is_closed' => $ticket->isClosed(),
                'userName' => $ticket->profile->fullName,
                'visits_number' => $ticket->visitsNumber,
            ]);
        }
        return back();
    }

    public function getCoachAttribute()
    {
        return Profile::where('id', $this->coach_id)->first();
    }

    public function scopeVisited($query)
    {
        return $query->where('visited', 1);
    }
}
