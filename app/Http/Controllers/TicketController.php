<?php

namespace App\Http\Controllers;

use App\Facades\Report;
use App\Models\Profile;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function index(Profile $profile)
    {
        return view('pages.ticket.index', [
            'profile' => $profile
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
        $updateData = ['end_date' => $request->end_date, 'created_at' => $request->created_at];
        Report::ticketReport(Auth::id(), 'Обновление дат абонемента', $ticket->id, $updateData);
        $ticket->update($updateData);
        return back();
    }

    public function destroy(Request $request, Profile $profile, Ticket $ticket)
    {
        Report::ticketReport(Auth::id(), 'Абонемент удален', $ticket->id);
        $ticket->delete();
        return redirect("/profile/".$profile->id."/ticket");
    }

    public function resumeTicket(Profile $profile, Ticket $ticket)
    {
        $ticket->resume(Auth::id());
        return back();
    }

    public function pauseTicket(Profile $profile, Ticket $ticket)
    {
        $ticket->pause(Auth::id());
        return back();
    }

    public function closeTicket(Profile $profile, Ticket $ticket)
    {
        $ticket->close(Auth::id());
        return back();
    }

    public function openTicket(Profile $profile, Ticket $ticket)
    {
        $ticket->open(Auth::id());
        return back();
    }
}
