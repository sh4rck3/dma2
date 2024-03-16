<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'message_id' => $this->message_id,
            'body' => $this->body,
            'read' => $this->read,
            'media_type' => $this->media_type,
            'ticket_id' => $this->ticket_id,
            'from_me' => $this->from_me,
            'is_deleted' => $this->is_deleted,
            'contact_id' => $this->contact_id,
            'created_at' => $this->created_at,
        ];
    }
}
