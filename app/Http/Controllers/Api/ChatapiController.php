<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Contact;
use App\Models\Ticket;
use App\Http\Resources\ChatResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
                            ->get();
        return ChatResource::collection($contacts);
    }

    public function messages(Ticket $ticket)
    {
        Log::info('ticket: '.$ticket);

        return 'ok';
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
    public function show(string $id)
    {
        //
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
