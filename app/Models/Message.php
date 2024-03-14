<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'message_id',
        'body',
        'read',
        'media_type',
        'ticket_id',
        'from_me',
        'is_deleted',
        'contact_id'
    ];

    public static function addMessage($request, $ticketId, $contactId)
    {
        $message = new Message();
        $message->message_id = $request->id;
        $message->body = $request->content;
        $message->read = 1;
        $message->media_type = $request->type;
        $message->ticket_id = $ticketId;
        $message->from_me = 0;
        $message->is_deleted = 0;
        $message->contact_id = $contactId;
        $message->save();
    }
}
