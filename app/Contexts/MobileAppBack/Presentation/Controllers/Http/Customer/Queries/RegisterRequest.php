<?php

namespace App\Contexts\MobileAppBack\Presentation\Controllers\Http\Customer\Queries;

use App\Contexts\MobileAppBack\Application\Commands\Customer\RegisterCustomer;
use App\Contexts\MobileAppBack\Application\Queries\Customer\GetToken;
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

    public function toCommand(): RegisterCustomer
    {
        return RegisterCustomer::of($this->name, $this->password, $this->email, $this->phone);
    }

    public function toQuery(): GetToken
    {
        return GetToken::of($this->email ?: $this->phone, $this->password, $this->deviceName);
    }
}
