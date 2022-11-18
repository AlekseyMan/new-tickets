<?php

namespace App\Models;

use App\Facades\Report;
use App\Traits\HasRolesAndPermissions;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

class Profile extends Model
{
    use HasFactory, HasRolesAndPermissions;

    const ROLE_KARATEKA = "karateka";
    const ROLE_PARENT = "parent";
    const ROLE_COACH = "coach";
    const QU = [
        '10',
        '9',
        '8',
        '7',
        '6',
        '5',
        '4',
        '3',
        '2',
        '1',
    ];
    const DAN = [
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
    ];

    protected $fillable = [
        'name',
        'surname',
        'patronymic',
        'qu',
        'dan',
        'birthday',
        'weight',
        'coach_id',
        'profile_role',
        'balance',
        'team_id',
        'user_id'
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class,'groups_profiles');
    }

    //Scopes
    public function scopeKarateki($query)
    {
        $id = Auth::id();
        $profile = Profile::where('user_id', $id)->first();
        if($profile->hasRole('admin')){
            return $query->where('profile_role', self::ROLE_KARATEKA)
                ->search()
                ->orderBy('surname')
                ->orderBy('name');
        };
        if($profile->hasRole('coach')){
            return $query->where('profile_role', self::ROLE_KARATEKA)
                ->where('coach_id', $profile->id)
                ->search()
                ->orderBy('surname')
                ->orderBy('name');
        };
    }

    public function scopeCoaches($query)
    {
        return $query->where('profile_role', self::ROLE_COACH)->orderBy('surname')->orderBy('name');
    }

    public function scopeSearch($query)
    {
        $search = request()->query();
        if (!empty($search)) {
            foreach ($search as $key => $value) {
                if (!empty($value)) {
                    $query->when($key, function ($q) use ($key, $value) {
                        $q->where($key, 'LIKE', "%$value%");
                    });
                }
            }
        }
        return $query;
    }

    //Attributes
    public function getTicketAttribute()
    {
        return Ticket::where('profile_id', $this->id)->where('is_closed', 0)->latest('id')->first();
    }

    public function getTicketsAttribute()
    {
        return Ticket::where('profile_id', $this->id)->orderBy('id', 'desc')->get();
    }

    public function getFullNameAttribute(): string
    {
        return $this->surname . " " . $this->name . " " . $this->patronymic;
    }

    //Methods
    public function updateBalance(int $value)
    {
        $newBalance = (int)$this->balance + $value;
        $this->update(['balance' => $newBalance]);
        Report::balanceReport(Auth::id(), $this, $value);
    }

    public function openNewTicket(int $value)
    {
        $this->updateBalance(-$value);
        return Ticket::create([
            'profile_id' => $this->id,
            'end_date' => Carbon::now()->addMonth()->subDay()
        ]);
    }

    public function isBlockedBalance(): bool
    {
        if ($this->updated_at < now()->addMinute(-1)) {
            return false;
        }
        return true;
    }
}
