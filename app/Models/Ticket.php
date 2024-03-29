<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'end_date',
        'is_closed',
        'paused',
        'pause_date'
    ];

    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class, 'ticket_id', 'id')->orderBy('date');
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class, 'id', 'profile_id');
    }

    public function isClosed(): bool
    {
        if(count($this->visits) >= Setting::whereName('visitsNumber')->first()->value OR $this->end_date < today()) {
            $this->update(['is_closed' => 1]);
            return 1;
        };
        return 0;
    }

    public function getVisitsNumberAttribute()
    {
        return Visit::where('ticket_id', $this->id)->visited()->count();
    }

    public function resume()
    {
        $unusedDays = strtotime($this->end_date) - strtotime($this->pause_date);
        $this->update([
            'end_date'   => Carbon::parse(strtotime(today()) + $unusedDays)->addDay()->format("Y-m-d"),
            'pause_date' => null,
            'paused'     => false
        ]);
    }

    public function pause()
    {
        $this->update([
            'pause_date' => today(),
            'paused'     => true
        ]);
    }

    public function close()
    {
        $this->update([
            'is_closed'     => true
        ]);
    }

    public function open()
    {
        $this->update([
            'is_closed'     => false
        ]);
    }

}
