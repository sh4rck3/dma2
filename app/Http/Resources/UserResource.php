<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        //Log::info("message - userresource - " . print_r($this->roles, true));
        return [
            'id'   => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'status' => $this->status,
            'extension' => $this->extension,
            'jobtitle' => $this->jobtitle,
            'sector' => $this->sector,
            'document' => $this->document,
            'birthday' => $this->birthday,
            'role_id' => $this->roles,
            'roles' => $this->roles,
            'created_at' => $this->created_at->toDateString(),
            
        ];
    }
}
