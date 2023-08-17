<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Profile;
use App\Models\School;
use App\Models\Setting;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function index()
    {
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        $data['schedule'] = json_encode($data['schedule']);
        Group::create($data);
        return back();
    }

    public function show(Group $group)
    {
        //TODO check works of schedule and remove it if done
        $availableVisitsNumber = Setting::whereName('visitsNumber')->first()->value;
        foreach ($group->karateki as $profile) {
            if(isset($profile->ticket)){
                if(count($profile->ticket?->visitsWithoutMisses) >= $availableVisitsNumber AND $profile->ticket?->paused !== true
                    OR $profile->ticket?->end_date < today() AND $profile->ticket?->paused !== true) {
                    Ticket::find($profile->ticket->id)->update(['is_closed' => 1]);
                };
            }
        }
        return view('pages.group.show', [
            'group' => $group,
            'school' => School::find($group->school_id)
        ]);
    }

    public function edit(Group $group)
    {
        return view('pages.group.edit', [
            'group'     => $group,
            'school'    => School::find($group->school_id),
            'coaches'   => Profile::coaches()->get(),
        ]);
    }

    public function update(Request $request, Group $group)
    {
        $data               = $request->except('_token', '_method');
        $data['schedule']   = json_encode($data['schedule']);
        Group::find($group->id)->update($data);
        return redirect('/school/' . $data['school_id']);
    }

    public function destroy(Group $group)
    {
        $group->delete();
        return back();
    }

    public function addKaratekaToGroup(Request $request, Group $group)
    {
        $nameArray = explode(" ", $request->name);
        if(count($nameArray) > 1){
            if($id = Profile::whereName($nameArray[1])->whereSurname($nameArray[0])->first()?->id){
                $group->karateki()->attach($id);
            }
        };
        return back();
    }

    public function removeFromGroup(Request $request, Group $group)
    {
        $group->karateki()->detach($request->profile_id);
        return back();
    }

    public function groupOnPause(Request $request, Group $group)
    {
        $group->allInGroupOnPauseFromDate($request->date, Auth::id());
        return response()->json(['message' => 'Все абонементы в группе поставлены на паузу']);
    }

    public function groupUnpause(Request $request, Group $group)
    {
        $group->allInGroupUnpauseFromDate(Auth::id());
        return response()->json(['message' => 'Все абонементы в группе убраны с паузы']);
    }
}
