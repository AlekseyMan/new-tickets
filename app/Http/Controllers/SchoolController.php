<?php

namespace App\Http\Controllers;

use App\Http\Requests\SchoolRequest;
use App\Models\Profile;
use App\Models\School;
use Illuminate\View\View;
use App\Facades\Report;

class SchoolController extends Controller
{
    public function index(): View
    {
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
