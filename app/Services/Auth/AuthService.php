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

        if (Arr::has($data, 'organisation_id')) {
            $user->organisations()->attach(Arr::get($data, 'organisation_id'));
        }

        $user->contact()->create(
            Arr::only($data, $this->contact->getFillable())
        );
        $user->load('contact');

        if (!Arr::has($data, 'organisation_id')) {
            $user->company()->create([
                'name' => $user->username
            ]);
        }

        SendRegisterEmail::dispatch($user)->onQueue('email_approve');

        return $user;
    }

    public function attempt(array $data): bool
    {
        $key = Arr::first(array_keys($data));

        return Auth::attempt([$key => $data[$key], 'password' => $data['password']]);
    }
}
