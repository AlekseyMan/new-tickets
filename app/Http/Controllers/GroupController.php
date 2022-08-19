<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

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
        return view('pages.group.show', [
            'group' => $group
        ]);
    }

    public function edit(Group $group)
    {
        return back();
    }

    public function update(Request $request, Group $group)
    {
        return back();
    }

    public function destroy(Group $group)
    {
        $group->delete();
        return back();
    }

    public function addKaratekiToGroup(Request $request, Group $group)
    {
        $group->karateki()->attach($request->ids);
        return back();
    }

    public function removeFromGroup(Request $request, Group $group)
    {
        $group->karateki()->detach($request->profile_id);
        return back();
    }
}
