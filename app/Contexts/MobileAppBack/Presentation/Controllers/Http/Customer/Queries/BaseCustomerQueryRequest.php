<?php

namespace App\Contexts\MobileAppBack\Presentation\Controllers\Http\Customer\Queries;

use Illuminate\Foundation\Http\FormRequest;

class BaseCustomerQueryRequest extends FormRequest
{
    protected const RULES = [
        'customerId' => 'required',
    ];

    protected const MESSAGES = [
        'customerId.required' => 'customerId required',
    ];

    public string $customerId;

    public function rules(): array
    {
        return array_merge(self::RULES, static::RULES);
    }

    public function messages(): array
    {
        return array_merge(self::MESSAGES, static::MESSAGES);
    }

    public function passedValidation(): void
    {
        $this->customerId = $this->input('customerId');
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'customerId' => $this->user()->id,
        ]);
    }

}
