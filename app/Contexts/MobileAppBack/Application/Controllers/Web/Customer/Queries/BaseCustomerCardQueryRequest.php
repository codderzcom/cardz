<?php

namespace App\Contexts\MobileAppBack\Application\Controllers\Web\Customer\Queries;

class BaseCustomerCardQueryRequest extends BaseCustomerQueryRequest
{
    protected const RULES = [
        'cardId' => 'required',
    ];

    protected const MESSAGES = [
        'cardId.required' => 'cardId required',
    ];

    public string $cardId;

    public function rules(): array
    {
        return array_merge(parent::rules(), self::RULES, static::RULES);
    }

    public function messages(): array
    {
        return array_merge(parent::messages(), self::MESSAGES, static::MESSAGES);
    }

    public function passedValidation(): void
    {
        parent::passedValidation();
        $this->cardId = $this->input('cardId');
    }

    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();
        $this->merge([
            'cardId' => $this->route('cardId'),
        ]);
    }

}
