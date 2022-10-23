<?php

namespace App\Http\Controllers;

use App\Http\Requests\SchoolRequest;
use App\Models\Profile;
use App\Models\Role;
use App\Models\School;
use Illuminate\View\View;
use App\Facades\Report;

class SchoolController extends Controller
{
    public function index(): View
    {
        //TODO убрать как только все будет настроено
        $profiles = Profile::where('profile_role', 'coach')->get();
        $coach    = Role::where('slug', 'coach')->first();
        $admin    = Role::where('slug', 'admin')->first();
        foreach($profiles as $profile){
            $profile->roles()->attach($coach);
        }
        $admins   = Profile::where('id', 1)->orWhere('id', 4)->get();
        foreach($admins as $profile){
            $profile->roles()->attach($admin);
        }
        return view('pages.school.index', ['schools' => School::all()]);
    }

    public function create(): View
    {
        return view('pages.school.create', ['coaches' => Profile::coaches()->get()]);
    }

    public function store(SchoolRequest $request, School $school)
    {
        $data = $request->validated();
        $data['contacts'] = json_encode($data['contacts']);
        $school->create($data);
        return back();
    }

    public function show(School $school): View
    {
        return view('pages.school.show', [
            'school' => $school,
            'coaches' => Profile::coaches()->get()
        ]);
    }

    public function edit(School $school): View
    {
        return view('pages.school.edit', ['school' => $school]);
    }

    public function update(SchoolRequest $request, School $school)
    {
        $school->update($request->validated());
        return redirect()->route('school.index');
    }

    public function destroy(School $school)
    {
        $school->delete();
        return back();
    }
}
