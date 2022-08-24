<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VisitController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request, Visit $visit)
    {
        return $visit->addVisitToTable($request->except('_token'));
    }

    public function show(Visit $visit)
    {
        //
    }

    public function edit(Visit $visit)
    {
        //
    }

    public function update(Request $request, Visit $visit)
    {
        //
    }

    public function destroy(Visit $visit)
    {
        $visit->delete();
        return back();
    }
}
