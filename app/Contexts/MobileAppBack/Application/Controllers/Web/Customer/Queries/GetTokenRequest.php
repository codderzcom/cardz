<?php

namespace App\Contexts\MobileAppBack\Application\Controllers\Web\Customer\Queries;

use Illuminate\Foundation\Http\FormRequest;

final class GetTokenRequest extends FormRequest
{
    public string $identity;

    public string $password;

    public string $deviceName;

    public function rules(): array
    {
        return [
            'identity' => 'required',
            'password' => 'required',
            'deviceName' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'identity.required' => 'identity required',
            'password.required' => 'password required',
            'deviceName.required' => 'deviceName required',
        ];
    }

    public function passedValidation(): void
    {
        $this->identity = $this->input('identity');
        $this->password = $this->input('password');
        $this->deviceName = $this->input('deviceName');
    }
}
