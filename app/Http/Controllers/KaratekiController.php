<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Redirect;

class KaratekiController extends Controller
{
    public function index()
    {
        return view('pages.karateki.index', [
            'karateki' => Profile::karateki()->get(),
            'coaches'  => Profile::coaches()->get(),
            'teams'     => Team::all()
        ]);
    }

    public function create()
    {
        return view('pages.karateki.create', [
            'coaches' => Profile::coaches()->get(),
            'role'    => Profile::ROLE_KARATEKA,
            'teams'    => Team::all()
        ]);
    }

    public function store(Request $request)
    {
        Profile::updateOrCreate($request->except('_token'));
        return back();
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        return view('pages.karateki.edit', [
            'coaches'  => Profile::coaches()->get(),
            'profile'  => Profile::find($id),
            'qus'      => Profile::QU,
            'dans'     => Profile::DAN,
            'teams'    => Team::all()->toArray() ?? []
        ]);
    }

    public function update(Request $request, $id)
    {
        Profile::find($id)->update($request->except(['_token', '_method']));
        return redirect('/karateki');
    }

    public function destroy($id)
    {

    }
}
