<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class School extends Model
{
    use HasFactory;

    const DAYS = [
        'Пн' => 'Понедельник',
        'Вт' => 'Вторник',
        'Ср' => 'Среда',
        'Чт' => 'Четверг',
        'Пт' => 'Пятница',
        'Сб' => 'Суббота',
        'Вс' => 'Воскресенье',
    ];

    protected $fillable = [
        'name',
        'address',
        'contacts',
        'description',
        'ticket_amount'
    ];

    public function groups(): HasMany
    {
        return $this->hasMany(Group::class);
    }

    public function getDaysAttribute(): array
    {
        return self::DAYS;
    }

    public function getKaratekiIdsAttribute() :array
    {
        $groups = Group::where('school_id', $this->id)->get();
        $result = [];
        foreach($groups as $group){
            if(!empty($group->karateki)){
                foreach ($group->karateki as $karateka){
                    $result[] = $karateka->id;
                }
            }
        }
        return $result;
    }

    public function getTicketAmountAttribute($value)
    {
        return $value ?? Setting::whereName('ticketAmount')->first()->value;
    }
}
