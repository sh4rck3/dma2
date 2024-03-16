<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);

        return [
            'id' => $this->id,
            'status' => $this->status,
            'last_message' => $this->last_message,
            'contact_id' => $this->contact_id,
            'user_id' => $this->user_id,
            'whatsapp_id' => $this->whatsapp_id,
            'is_group' => $this->is_group,
            'unread_messages' => $this->unread_messages,
            'queeu_id' => $this->queeu_id,
            'created_at' => $this->created_at,
            // 'name' => $this->name,
            // 'number' => $this->number,
            // 'is_group' => $this->is_group,

        ];
    }
}
