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
        'description'
    ];

    public function groups(): HasMany
    {
        return $this->hasMany(Group::class);
    }

    public function getDaysAttribute(): array
    {
        return self::DAYS;
    }
}
