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

    public function resumeTicket(Profile $profile, Ticket $ticket)
    {
        $ticket->resume();
        return back();
    }

    public function pauseTicket(Profile $profile, Ticket $ticket)
    {
        $ticket->pause();
        return back();
    }

    public function closeTicket(Profile $profile, Ticket $ticket)
    {
        $ticket->close();
        return back();
    }

    public function openTicket(Profile $profile, Ticket $ticket)
    {
        $ticket->open();
        return back();
    }
}
