<?php

namespace App\Contexts\Personal\Presentation\Controllers\Http\Person\Commands;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseCommandRequest extends FormRequest
{
    protected const RULES = [
        'personId' => 'required',
    ];

    protected const MESSAGES = [
        'personId.required' => 'personId required',
    ];

    public string $personId;

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
        $this->personId = $this->input('personId');
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'personId' => $this->route('personId'),
        ]);
    }

}
