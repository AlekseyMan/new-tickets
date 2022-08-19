<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(Profile $profile)
    {
        return view('pages.ticket.index', [
            'profile' => $profile,
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Profile $profile, Ticket $ticket)
    {

    }

    public function edit(Profile $profile, Ticket $ticket)
    {
        return view('pages.ticket.edit', [
            'profile' => $profile,
            'ticket' => $ticket
        ]);
    }

    public function update(Request $request, Profile $profile, Ticket $ticket)
    {
        $ticket->update(['end_date' => $request->end_date]);
        return back();
    }

    public function destroy(Ticket $ticket)
    {
        //
    }
}
