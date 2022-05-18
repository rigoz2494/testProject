<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'username' => $this->resource->username,
            'contact' => $this->contactDTO($this->resource->contact)
        ];
    }

    private function contactDTO($data): array
    {
        return [
            'first_name' => $data->first_name,
            'last_name' => $data->last_name,
            'middle_name' => $data->middle_name,
            'age' => $data->age,
        ];
    }
}
