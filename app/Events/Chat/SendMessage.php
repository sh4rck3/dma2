<?php

namespace App\Events\Chat;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Legal;

class SendMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $legal;

    /**
     * Create a new event instance.
     */
    public function __construct(Legal $legal)
    {
        $this->legal = $legal;
    }

     /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'SendMessage';
    } 

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastWith()
    {
       return [
           'id' => $this->legal->id,
           'title' => $this->legal->title,
           'status' => $this->legal->status,
           'description' => $this->legal->description,
           'file' => $this->legal->file,
           'path' => $this->legal->path,
           'original_name' => $this->legal->original_name,
           'created_at' => $this->legal->created_at->format('d/m/Y H:i:s'),
       ]; 
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new Channel('newlegal');
    }

   
}
