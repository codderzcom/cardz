<?php

namespace App\Contexts\Cards\Presentation\Controllers\Http\Card\Commands;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseCommandRequest extends FormRequest
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
        return array_merge(self::RULES, static::RULES);
    }

    public function messages(): array
    {
        return array_merge(self::MESSAGES, static::MESSAGES);
    }

    public function passedValidation(): void
    {
        $this->cardId = $this->input('cardId');
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'cardId' => $this->route('cardId'),
        ]);
    }

}
