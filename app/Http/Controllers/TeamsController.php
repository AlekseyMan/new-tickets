<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamsController extends Controller
{
    public function index()
    {
        return view('pages.teams.index', [
            'karateki' => Profile::karateki()->get(),
            'coaches' => Profile::coaches()->get(),
            'teams' => Team::all()
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        Team::updateOrCreate([
                'name' => $request->name
            ],
            [
                'team_number' => $request->team_number
            ]);
        return back();
    }

    public function show()
    {
        return view('pages.teams.show', [
            'teams' => Team::where('name', '<>', 'Без команды')->get()
        ]);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, Team $team)
    {
        $team->update($request->except(['_token', '_method']));
        return back();
    }

    public function destroy(Team $team)
    {
        $team->karateki()->update(['team_id' => null]);
        $team->delete();
        return back();
    }

    public function updateKaratekiTeams(Request $request, Team $team)
    {
        $team->updateTeams($request->teams);
        return back();
    }
}
