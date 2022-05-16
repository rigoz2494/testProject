<?php

namespace App\Services\Auth;

use App\Jobs\SendRegisterEmail;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    protected User $user;

    protected Contact $contact;

    public function __construct(User $user, Contact $contact)
    {
        $this->user = $user;
        $this->contact = $contact;
    }

    public function register(array $data): User
    {
        $user = $this->user->create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);

        if (Arr::has($data, 'organisation')) {
            $user->organisations()->attach(Arr::get($data, 'organisation'));
        }

        $user->contact()->create(
            Arr::only($data, $this->contact->getFillable())
        );

        if (Arr::has($data, 'new_organisation')) {
            $user->createdOrganisation()->create([
                'name' => $user->contact->fullName
            ]);
        }

        SendRegisterEmail::dispatch($user)->onQueue('email_approve');

        return $user;
    }

    public function attempt(array $data): bool
    {
        $isEmail = filter_var($data['login'], FILTER_VALIDATE_EMAIL);

        $loginField = $isEmail ? 'email' : 'username';

        return Auth::attempt([$loginField => $data['login'], 'password' => $data['password']]);
    }
}
