<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'contact' => [
                'first_name' => $this->contact->first_name,
                'last_name' => $this->contact->last_name,
                'middle_name' => $this->contact->middle_name,
                'age' => $this->contact->age,
            ]
        ];
    }
}
