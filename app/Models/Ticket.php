<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        $exists = Ticket::where('status', 'open')->where('contact_id', $idContact)->exists();
        if($exists){
            return true;
        }else{
            return false;
        }
    }
}
