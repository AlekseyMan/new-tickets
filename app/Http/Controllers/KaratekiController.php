<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Redirect;

class KaratekiController extends Controller
{
    public function index()
    {
        return view('pages.karateki.index', ['karateki' => Profile::karateki()->get()]);
    }

    public function create()
    {
        return view('pages.karateki.create', [
            'coaches' => Profile::coaches()->get(),
            'role'    => Profile::ROLE_KARATEKA
        ]);
    }

    public function store(Request $request)
    {
        Profile::create($request->except('_token'));
        return back();
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        return view('pages.karateki.edit', [
            'coaches' => Profile::coaches()->get(),
            'profile'  => Profile::find($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        Profile::find($id)->update($request->except(['_token', '_method']));
        return redirect('/karateki');
    }

    public function destroy($id)
    {
        //
    }
}
