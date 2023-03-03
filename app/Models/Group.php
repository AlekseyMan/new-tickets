<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'coach_id',
        'school_id',
        'name',
        'schedule',
        'temporary_info',
        'ticket_amount'
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class, 'id', 'school_id');
    }

    public function karateki(): BelongsToMany
    {
        return $this->belongsToMany(Profile::class, 'groups_profiles')
            ->orderBy('surname')
            ->orderBy('name');
    }

    public function getFormatedScheduleAttribute()
    {
        $days  = "";
        $times = "";
        foreach(json_decode($this->schedule) as $key => $params){
            foreach ($params as $value){
                $key === 'days'
                    ? $days .= $value . ", "
                    : $times .= $value . "-";
            }
        }
        return substr($days, 0, -2) . ": " . substr($times, 0, -1);
    }

    public function coach(): HasOne
    {
        return $this->hasOne(Profile::class, 'id', 'coach_id');
    }

    public function getTicketAmountAttribute($value)
    {
        return $value ?? School::find($this->school_id)->ticket_amount;
    }
}
