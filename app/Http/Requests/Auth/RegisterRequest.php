<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'password.min' => 'Parolei jābūt vismaz :min rakstzīmju garai.',
            'password.letters' => 'Parolei jāietver vismaz viena burta.',
            'password.mixedCase' => 'Parolei jāietver vismaz viena lielā un viena maza burta.',
            'password.numbers' => 'Parolei jāietver vismaz viens cipars.',
            'password.symbols' => 'Parolei jāietver vismaz viens simbols.',
        ];
    }
}
