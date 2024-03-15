<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//use Illuminate\Support\Facades\Log;
//use App\Models\Codedddstate;
use Illuminate\Support\Facades\Auth;

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

    public static function sendMessage($request, $ticketId, $contactId, $userSendCell)
    {
        if($userSendCell == 1)
        {
            $userLoged = 1;
            $mensagem = "*Enmviado pelo Cel*\r\n".filter_var($request->content, FILTER_SANITIZE_STRIPPED);
        }else{
            $userLoged = Auth::user()->id;
            $mensagem = "*".Auth::user()->name.":*\r\n".filter_var($request->content, FILTER_SANITIZE_STRIPPED);

        }
        $message = new Message();
        $message->message_id = $request->id;
        $message->body = $mensagem;
        $message->read = 1;
        $message->media_type = $request->type;
        $message->ticket_id = $ticketId;
        $message->from_me = $userLoged;
        $message->is_deleted = 0;
        $message->contact_id = $contactId;
        $message->save();
    }
}
