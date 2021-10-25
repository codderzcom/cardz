<?php

namespace App\Contexts\Auth\Presentation\Controllers\Http\User\Commands;

use App\Contexts\Auth\Application\Commands\RegisterUser;
use App\Contexts\Auth\Application\Commands\RegisterUserCommandInterface;
use Illuminate\Foundation\Http\FormRequest;

final class RegisterUserRequest extends FormRequest
{
    public string $name;

    public string $password;

    public ?string $email;

    public ?string $phone;

    public function rules(): array
    {
        return [
            'name' => 'required',
            'password' => 'required',
            'email' => 'required_without:phone',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'name required',
            'password.required' => 'password required',
            'email.required_without' => 'email required if phone is not provided',
        ];
    }

    public function passedValidation(): void
    {
        $this->name = $this->input('name');
        $this->password = $this->input('password');
        $this->email = $this->input('email');
        $this->phone = $this->input('phone');
    }

    public function toCommand(): RegisterUserCommandInterface
    {
        return RegisterUser::of($this->name, $this->password, $this->email, $this->phone);
    }

}
