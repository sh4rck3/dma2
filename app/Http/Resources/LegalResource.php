<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LegalResource extends JsonResource
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
            'user_id' => $this->user_id,
            'username' => $this->username,
            'title' => $this->title,
            'original_name' => $this->original_name,
            'path' => $this->path,
            'status' => $this->status,
            'description' => $this->description,
            'file' => $this->file,
            'created_at' => $this->created_at->toDateString(),
        ];
    }
}
