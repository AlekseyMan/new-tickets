<?php

namespace App\Models;

use App\Facades\Report;
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
        'pause_date',
        'created_at'
    ];

    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class, 'ticket_id', 'id')->orderBy('date');
    }

    public function visitsWithoutMisses(): HasMany
    {
        return $this->hasMany(Visit::class, 'ticket_id', 'id')->whereVisited('1')->orderBy('date');
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class, 'profile_id', 'id');
    }

    public function isClosed(): bool
    {
        if(count($this->visitsWithoutMisses) >= Setting::whereName('visitsNumber')->first()->value OR $this->end_date < today()) {
            $this->update(['is_closed' => 1]);
            return 1;
        };
        return 0;
    }

    public function getVisitsNumberAttribute()
    {
        return Visit::where('ticket_id', $this->id)->visited()->count();
    }

    public function getVisitAttribute()
    {
        if(isset($_GET['for_date'])){
            $date = $_GET['for_date'];
        } else {
            $date = today();
        }
        return Visit::where('ticket_id', $this->id)->where('date', $date)->where('visited', 1)->first();
    }

    public function getMissAttribute()
    {
        if(isset($_GET['for_date'])){
            $date = $_GET['for_date'];
        } else {
            $date = today();
        }
        return Visit::where('ticket_id', $this->id)->where('date', $date)->where('visited', 0)->first();
    }

    public function resume($userId)
    {
        $unusedDays = strtotime($this->end_date) - strtotime($this->pause_date);
        $updateParams = [
            'end_date'   => Carbon::parse(strtotime(today()) + $unusedDays)->addDay()->format("Y-m-d"),
            'pause_date' => null,
            'paused'     => false
        ];
        Report::ticketReport($userId, 'Возобновление действия абаонемента', $this->id, $updateParams);
        $this->update($updateParams);
    }

    public function pause($userId)
    {
        $updateParams = [
            'pause_date' => today(),
            'paused'     => true
        ];
        Report::ticketReport($userId, 'Абонемент поставлен на паузу', $this->id, $updateParams);
        $this->update($updateParams);
    }

    public function close($userId)
    {
        Report::ticketReport($userId, 'Абонемент закрыт', $this->id, ['is_closed'     => true]);
        $this->update([
            'is_closed'     => true
        ]);
    }

    public function open($userId)
    {
        Report::ticketReport($userId, 'Абонемент открыт', $this->id, ['is_closed'     => false]);
        $this->update([
            'is_closed'     => false
        ]);
    }
}
