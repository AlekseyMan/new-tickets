<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CoachesController extends Controller
{
    public function index()
    {
        return view('pages.coaches.index', [
            'coaches' => Profile::coaches()->get()
        ]);
    }

    public function create()
    {
        return view('pages.coaches.create', [
            'coaches' => Profile::coaches()->get(),
            'role'    => Profile::ROLE_COACH,
        ]);
    }

    public function store(Request $request)
    {
        $userData = $request->except('_token', 'profile_role', 'surname', 'name', 'patronymic', 'birthday', 'weight');
        $userData['login'] = $userData['email'];
        $userData['password'] = Hash::make($userData['password']);
        User::create($userData);
        $profileData = $request->except('_token', 'email', 'password');
        $profileData['user_id'] = User::whereEmail($request->email)->first()->id;
        Profile::create($profileData);
        return back();
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $profile = Profile::find($id);
        return view('pages.coaches.edit', [
            'coach'    => $profile,
            'user'     => User::find($profile->user_id),
            'qus'      => Profile::QU,
            'dans'     => Profile::DAN,
        ]);
    }

    public function update(Request $request, $id)
    {
        Profile::find($id)->update($request->except(['_token', '_method']));
        return redirect()->route('coaches.index');
    }

    public function destroy($id)
    {
        //
    }
}
