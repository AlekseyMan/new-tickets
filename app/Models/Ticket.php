<?php

namespace App\Models;

use App\Facades\Report;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;

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

        if($this->pause_date !== null){
            $unusedDays = strtotime($this->end_date) - strtotime($this->pause_date);
            $end_date = Carbon::parse(strtotime(today()))->addDays($unusedDays / (60 * 60 * 24) + 1)->format("Y-m-d");
        }else {
            $end_date = Carbon::parse(strtotime(today()))->addDay()->format("Y-m-d");
        }
        $updateParams = [
            'end_date'   => $end_date,
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

    public function onPauseFromDate($date, $userId)
    {
        $date =  is_null($date) ? today() : date('Y-m-d', strtotime($date));
        $updateParams = [
            'paused'     => true,
            'pause_date' => $date
        ];
        if($this->is_closed == 0 and $this->paused == 0){
            $this->update($updateParams);
            Report::ticketReport($userId, 'Абонемент поставлен на паузу', $this->id, $updateParams);
        }
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

    public function getReport($params, $shortReport = true)
    {
        $userId         = Profile::find($params['coach_id'])->user_id;
        $startDate      = date("Y-m-d H:i:s", strtotime("{$params['year']}-{$params['month']}-1 00:00:01"));
        $lastDay        = date('t', strtotime($startDate));
        $endDate        = date("Y-m-d H:i:s", strtotime("{$params['year']}-{$params['month']}-{$lastDay} 23:59:59"));
        $schools        = School::all();
        $openedTickets  = [];
        $schoolsResult  = [];
        $payments       = [];
        $totalOpened    = 0;
        $totalPaid      = 0;
        foreach ($schools as $school){
            $opened     = Reports::where('type', 'ticket')
                ->where('user_id', $userId)
                ->where('created_at', '>', $startDate)
                ->where('created_at', '<', $endDate)
                ->whereJsonContains('data->action', "Открыт новый абонемент")
                ->get();
            $opened = array_filter($opened->toArray(), function($elem) use ($school){
                return in_array(json_decode($elem['data'],true)['oldValues'][1]['profile_id'], $school->karatekiIds);
            });
            $paid   = Reports::whereIn('model_id', $school->karatekiIds)
                ->where('type', 'profile')
                ->where('user_id', $userId)
                ->where('created_at', '>', $startDate)
                ->where('created_at', '<', $endDate)
                ->whereJsonContains('data->action', "Оплата за абонемент")
                ->get();
            $shortReport ?: $openedTickets  = array_merge($openedTickets, $opened);
            $shortReport ?: $payments       = array_merge($payments, $paid->toArray());
            $schoolsResult[$school->name]['opened'] = count($opened);
            $schoolsResult[$school->name]['paid']   = count($paid);
            $totalOpened                            = $totalOpened + count($opened);
            $totalPaid                              = $totalPaid + count($paid);
        }

        return json_encode([
            'opened'        => $totalOpened,
            'paid'          => $totalPaid,
            'schools'       => $schoolsResult,
            'reportsArray'  => $openedTickets,
            'paidArray'     => $payments
        ]);
    }

    public function getAdvancedReport($params):array
    {
        $data                = json_decode($this->getReport($params, false), true);
        $openedIdsArray      = $this->getIdsArray($data['reportsArray']);
        $paymentsIdsArray    = $this->getIdsArray($data['paidArray']);
        $profilesForOpened   = Profile::select('id', 'surname', 'name')
            ->whereIn('id',$openedIdsArray)
            ->orderBy('created_at')
            ->get()
            ->toArray();
        $profilesForPayments = Profile::select('id', 'surname', 'name')
            ->whereIn('id',$paymentsIdsArray)
            ->orderBy('created_at')
            ->get()
            ->toArray();
        return [
                'opened'   => $this->getArrayForReport($data['reportsArray'], $profilesForOpened),
                'payments' => $this->getArrayForReport($data['paidArray'], $profilesForPayments, 'payment')
            ];
    }

    private function getArrayForReport($data, $profiles, $type = 'opened'):array
    {
        return array_map(function($value) use ($profiles, $type)
        {
            foreach ($profiles as $profile){
                if($type === 'opened') {
                    $tempData = json_decode($value['data']);
                    if($profile['id'] === $tempData->oldValues[1]->profile_id){
                        return [
                            'name'      => $profile['surname'] . " " .  $profile['name'],
                            'date'      => date("d-m-Y", strtotime($tempData->oldValues[6]->created_at)),
                            'action'    => $tempData->action,

                        ];
                    }
                } else {
                    if($profile['id'] === $value['model_id']){
                        return [
                            'name'      => $profile['surname'] . " " .  $profile['name'],
                            'date'      => date("d-m-Y", strtotime($value['created_at'])),
                            'action'    => json_decode($value['data'])->action,
                            'amount'    => json_decode($value['data'])->payment
                        ];
                    }
                }
            }
            return null;
        }, $data);
    }

    private function getIdsArray($data)
    {
        return array_map(function($value){
            if(json_decode($value['data'])->action === 'Открыт новый абонемент'){
                return json_decode($value['data'])->oldValues[1]->profile_id;
            }
            return $value['model_id'];
        }, $data);
    }
}
