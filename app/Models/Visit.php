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
        $ticket = Ticket::find($data['ticket_id']);
        if(isset($data['date'])) {
            $this->create($data);
            $ticket->isClosed();
            return back();
        } else {
            $data['coach_id'] = Profile::where('user_id', Auth::id())->first()->id;
            $data['date'] = today()->format("Y-m-d");
            $this->updateOrCreate(
                [
                    'date' => today()->format("Y-m-d"),
                    'ticket_id' => $data['ticket_id']
                ],
                $data);
            return response()->json([
                'is_closed' => $ticket->isClosed(),
                'visits_number' => $ticket->visitsNumber
            ]);
        }
    }

    public function getCoachAttribute(){
        return Profile::where('id', $this->coach_id)->first();
    }

    public function scopeVisited($query)
    {
        return $query->where('visited', 1);
    }
}
