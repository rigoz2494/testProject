<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\User;

class UserService
{
    public function __construct(protected User $user)
    {
    }

    public function getUserData(int $id): UserResource
    {
        $user = $this->user->with('contact')->find($id);

        return new UserResource($user);
    }
}
