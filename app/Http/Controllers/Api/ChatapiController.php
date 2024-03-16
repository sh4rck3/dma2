<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Contact;
use App\Models\Ticket;
use App\Http\Resources\ChatResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\MessageResource;
use Symfony\Component\HttpFoundation\Response;

class ChatapiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userLogged = Auth::user()->id;
        //Log::info('userLogged: '.$userLogged);
        $contacts = Ticket::where('tickets.user_id', '=', $userLogged)
                            ->join('contacts', 'contacts.id', '=', 'tickets.contact_id')
                            ->select('tickets.*', 'contacts.name', 'contacts.number', 'contacts.profile_pic_url', 'contacts.email', 'contacts.is_group')
                            ->orderBy('tickets.id', 'desc')
                            ->get();
        return ChatResource::collection($contacts);
    }

    public function messages(Ticket $ticket)
    {
        $userFrom = Auth::user()->id;
        $userTo = $ticket->contact_id;

        $mensagens = Ticket::where('tickets.id', '=', $ticket->id)//id ticket 28
                            ->join('messages', 'messages.ticket_id', '=', 'tickets.id')
                            ->select('messages.*')
                            ->get();
        return MessageResource::collection($mensagens);
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        $userFrom = Auth::user()->id;
        $userTo = $ticket->contact_id;

        $contactTicket = Ticket::where('tickets.id', '=', $ticket->id)//id ticket 28
                            ->join('contacts', 'contacts.id', '=', 'tickets.contact_id')
                            ->select('tickets.*', 'contacts.name', 'contacts.number', 'contacts.is_group')
                            ->first();
        return response()->json(['ticketUser' => $contactTicket], Response::HTTP_OK); 
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
