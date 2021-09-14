<?php

namespace App\Contexts\Auth\Application\Controllers\Web\User\Commands;

use Illuminate\Foundation\Http\FormRequest;

final class RegisterUserRequest extends FormRequest
{
    public string $name;
    public string $password;
    public string $email;
    public ?string $phone;

    public function rules(): array
    {
        return [
            'name' => 'required',
            'password' => 'required',
            'email' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'name required',
            'password.required' => 'password required',
            'email.required' => 'email required',
        ];
    }

    public function passedValidation(): void
    {
        $this->name = $this->input('name');
        $this->password = $this->input('password');
        $this->email = $this->input('email');
        $this->phone = $this->input('phone');
    }

}
