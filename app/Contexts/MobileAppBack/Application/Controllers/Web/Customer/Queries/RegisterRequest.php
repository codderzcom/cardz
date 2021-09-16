<?php

namespace App\Contexts\MobileAppBack\Application\Controllers\Web\Customer\Queries;

use Illuminate\Foundation\Http\FormRequest;

final class RegisterRequest extends FormRequest
{
    public ?string $email;

    public ?string $phone;

    public string $name;

    public string $password;

    public string $deviceName;

    public function rules(): array
    {
        return [
            'email' => 'required_without:phone',
            'name' => 'required',
            'password' => 'required',
            'deviceName' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required_without' => 'email required if phone is not provided',
            'name.required' => 'name required',
            'password.required' => 'password required',
            'deviceName.required' => 'deviceName required',
        ];
    }

    public function passedValidation(): void
    {
        $this->email = $this->input('email');
        $this->phone = $this->input('phone');
        $this->name = $this->input('name');
        $this->password = $this->input('password');
        $this->deviceName = $this->input('deviceName');
    }
}
