<?php

namespace App\Http\Controllers;

use App\Facades\Report;
use App\Models\Group;
use App\Models\Profile;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    public function index()
    {
        dd("Test complete");
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

    public function addPaymentForTicket(Profile $profile, Group $group)
    {
        $profile->updateBalance($group->ticket_amount, 'Оплата за абонемент');
        return back();
    }

    public function newTicket(Profile $profile, Group $group)
    {
        if($ticket = $profile->openNewTicket($group->ticket_amount)){
            Report::ticketReport(Auth::id(), 'Открыт новый абонемент', $ticket->id);
        };
        return back();
    }

    public function updateBalance(Request $request, Profile $profile)
    {
        $profile->updateBalance((int)$request->amount);
        return back();
    }
}
