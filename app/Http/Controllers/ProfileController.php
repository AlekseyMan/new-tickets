<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Setting;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        //
    }

    public function destroy(Profile $profile)
    {
        $profile->delete();
        return redirect()->route('karateki.index');
    }

    public function addPaymentForTicket(Profile $profile)
    {
        $profile->updateBalance(Setting::whereName('ticketAmount')->first()->value);
        return back();
    }

    public function newTicket(Profile $profile)
    {
        $profile->openNewTicket(Setting::whereName('ticketAmount')->first()->value);
        return back();
    }

    public function updateBalance(Request $request, Profile $profile)
    {
        $profile->updateBalance($request->amount);
        return back();
    }
}
