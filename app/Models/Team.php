<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'team_number'
    ];

    public function karateki(): HasMany
    {
        return $this->hasMany(Profile::class, 'team_id', 'id')
            ->orderBy('surname')
            ->orderBy('name');
    }

    public function updateTeams(array $teams)
    {
        foreach ($teams as $teamId => $members){
            Profile::whereIn('id', array_keys($members))
                ->update(['team_id' => $teamId]);
        }
    }

    public function getTeamMembersAttribute()
    {
        return $this->karateki;
    }
}
