<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use App\Models\Contact;
use App\Models\Ticket;
use App\Models\Message;
use Illuminate\Support\Facades\Event;
use App\Events\Chat\NewTicket;


class ApiwhatsController extends Controller
{
   
    public function store(Request $request)
    {
        Log::info('Whatsapp: ' . print_r($request->all(), true));
    }

    public function statusconect(Request $request)
    {
        Log::info('statusconect: ' . print_r($request->all(), true));
    }

    public function qrcode(Request $request)
    {
        Log::info('qrcode: ' . print_r($request->all(), true));
    }

    public function status(Request $request)
    {
        Log::info('status: ' . print_r($request->all(), true));
    }

    public function mensagem(Request $request)
    {
        Log::info('mensagem: ' . print_r($request->all(), true));
           
        if(Contact::verifyContact($request->from)){
            Log::info('contato encontrado');
            $contact = Contact::where('number', $request->from)->first();
            if(Ticket::verifyTicket($contact->id)){
                Log::info('ticket foi encontrado');
            }else{
                Log::info('criando ticket');
                $ticket = new Ticket();
                $ticket->status = 'open';
                $ticket->contact_id = $contact->id;
                $ticket->user_id = null;
                $ticket->whatsapp_id = $request->container;
                $ticket->unread_messages = 0;
                $ticket->queue_id = 1;
                $ticket->save();
                if(isset($ticket->id)){
                    Log::info('criando mensagem');
                    $message = new Message();
                    $message->message_id = $request->id;
                    $message->body = $request->content;
                    $message->read = 0;
                    $message->media_type = $request->type;
                    $message->ticket_id = $ticket->id;
                    $message->from_me = 0;
                    $message->is_deleted = 0;
                    $message->contact_id = $contact->id;
                    $message->save();
                    //Event::dispatch(new NewTicket($ticket->id));
                }
            }
            
        }else{
            Log::info('contato não encontrado');
        }
        // if(Contact::verifyContact($request->from)){
        //     Log::info('dentro do if true');
        // }else{
        //     Log::info('dentro do if false');
        // }              
        // if(Contact::where('number', $request->from))
        // {
        //     $user = Contact::where('number', $request->from)->first();
        //     $numberTicket = Ticket::where('status', 'open')->where('contact_id', $user->id)->get();
        //     if($numberTicket){
        //         $message = new Message();
        //         $message->message_id = $request->id;
        //         $message->body = $request->content;
        //         $message->read = 0;
        //         $message->media_type = $request->type;
        //         $message->ticket_id = $numberTicket->id;
        //         $message->from_me = 1;
        //         $message->is_deleted = 0;
        //         $message->contact_id = $user->id;
        //         $message->save();
                
        //         Event::dispatch(new NewTicket($numberTicket));
        //     }
        // }else{
        //     $contact = new Contact();
        //     $contact->name = $request->pushName;
        //     $contact->number = $request->from;
        //     $contact->save();
        //     if(isset($contact->id)){
        //         $ticket = new Ticket();
        //         $ticket->status = 'open';
        //         $ticket->contact_id = $contact->id;
        //         $ticket->user_id = null;
        //         $ticket->whatsapp_id = $request->container;
        //         $ticket->queue_id = 1;
        //         $ticket->save();

        //         Event::dispatch(new NewTicket($ticket->id));

        //         if(isset($ticket->id)){
        //             $message = new Message();
        //             $message->message_id = $request->id;
        //             $message->body = $request->content;
        //             $message->read = 0;
        //             $message->media_type = $request->type;
        //             $message->ticket_id = $ticket->id;
        //             $message->from_me = 1;
        //             $message->is_deleted = 0;
        //             $message->contact_id = $contact->id;
        //             $message->save();
                    
                    
        //         }
        //     }
        // }
        
        
    }

    public function call(Request $request)
    {
        Log::info('call: ' . print_r($request->all(), true));
    }

    public function delete(Request $request)
    {
        Log::info('delete: ' . print_r($request->all(), true));
    }

    public function presenca(Request $request)
    {
        Log::info('presenca: ' . print_r($request->all(), true));
    }

}
