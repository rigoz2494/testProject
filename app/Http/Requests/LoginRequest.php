<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username'  =>  ['required_without:email', 'string'],
            'email'  =>  ['required_without:username', 'string'],
            'password' => ['required']
        ];
    }
}
