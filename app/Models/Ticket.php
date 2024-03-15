<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Log;

class Ticket extends Model
{
    use HasFactory;

    protected $idContact;

    protected $fillable = [
        'status',
        'last_message',
        'contact_id',
        'user_id',
        'whatsapp_id',
        'is_group',
        'unread_messages',
        'queue_id'
    ];

    public static function verifyTicket($idContact)
    {
        
        return Ticket::where('status', 'open')
                       ->where('contact_id', $idContact)
                       ->first() !== null;
    }

    public static function getIdTicket($idContact)
    {
        $ticketId = Ticket::where('status', 'open')
                    ->where('contact_id', $idContact)
                    ->first();
        return $ticketId;
    }

    public static function addTicket($request, $contactId)
    {
        $ticket = new Ticket();
        $ticket->status = 'open';
        $ticket->contact_id = $contactId;
        $ticket->user_id = null;
        $ticket->whatsapp_id = $request->container;
        $ticket->unread_messages = 1;
        $ticket->queue_id = 1;
        $ticket->save();

        return $ticket;
    }

}
