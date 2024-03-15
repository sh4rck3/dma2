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
use App\Models\Codedddstate;
use Illuminate\Support\Facades\Auth;


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
        //Log::info('status: ' . print_r($request->all(), true));
        if($request->status == 'MOBILE')
        {
            $userSendCell = 1;
            //Log::info('status: ' . print_r($request->all(), true));
            //Log::info('Enviado pelo celular');
            if($request->type == 'text')
            {
                //Log::info('status: ' . print_r($request->all(), true));
                Log::info('Enviado pelo celular');
                $toContact = Contact::where('number', $request->to)->first();
                if($toContact)
                {
                    Log::info('contato encontrado');
                    if(Ticket::verifyTicket($toContact->id))
                    {
                        Log::info('ticket foi encontrado');
                        $ticketId = Ticket::getIdTicket($toContact->id);
                        if($ticketId->user_id == null)
                        {
                            Log::info('ticket sem atendente');
                            Ticket::where('id', $ticketId->id)->update(['user_id' => $userSendCell]);
                            Log::info('ticket com atendente: 1');
                            Message::sendMessage($request, $ticketId->id, $toContact->id, $userSendCell);
                            Log::info('mensagem enviada');
                        }else{
                            Log::info('ticket com atendente');
                            Message::sendMessage($request, $ticketId->id, $toContact->id, $userSendCell);
                            Log::info('mensagem enviada');
                        }
                        
                        
                    }   
                }
             
                

                if($request->isgroup == 1)
                {
                    Log::info('mensagem para o grupo');
                }

            }
        }
    }

    public function mensagem(Request $request)
    {
        
        
        if($request->isgroup == 1)
        {
            Log::info('mensagem: ' . print_r($request->all(), true));
            Log::info('mensagem de grupo');
            if(Contact::verifyGroup($request->from))
            {
                Log::info('grupo encontrado');
                
            }
            
            return;
        }

        if(Contact::verifyContact($request->from)){
            Log::info('contato encontrado');
            $contact = Contact::where('number', $request->from)->first();
            $testeTicket = Ticket::verifyTicket($contact->id);
            if(Ticket::verifyTicket($contact->id)){
                Log::info('ticket foi encontrado');
                $ticketId = Ticket::where('status', 'open')->where('contact_id', $contact->id)->first();
                $i = 0;
                if($ticketId->unread_messages >= 0){
                    $i = $ticketId->unread_messages + 1;
                    Ticket::where('id', $ticketId->id)->update(['unread_messages' => $i]);
                    Message::addMessage($request, $ticketId->id, $contact->id);
                    Log::info('mensagem inserida na tabela');
                }
            }else{
                Log::info('criando ticket');
                $ticket = Ticket::addTicket($request, $contact->id);
                if(isset($ticket->id)){
                    Log::info('criando mensagem');
                    Message::addMessage($request, $ticket->id, $contact->id);
                    //Event::dispatch(new NewTicket($ticket->id));
                }
            }
            
        }else{
            Log::info('contato não encontrado');
            $contact = Contact::addContact($request);
            if($contact->id)
            {
                $ticket = Ticket::addTicket($request, $contact->id);
                Log::info('criando ticket');
                if($ticket->id)
                {
                    Message::addMessage($request, $ticket->id, $contact->id);
                    //Event::dispatch(new NewTicket($ticket->id));
                    Log::info('mensagem inserida na tabela');
                }
            }
        }
        
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
