<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->user_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'avatar'=> $this->avatar,
            'verified' => $this->email_verified_at ? true : false,
            'active' =>$this->is_active
        ];
    }
}
