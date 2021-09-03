<?php

namespace App\Contexts\Plans\Application\Controllers\Web\Requirement\Commands;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseCommandRequest extends FormRequest
{
    protected const RULES = [
        'requirementId' => 'required',
    ];

    protected const MESSAGES = [
        'requirementId.required' => 'requirementId required',
    ];

    public string $requirementId;

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
        $this->requirementId = $this->input('requirementId');
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'requirementId' => $this->route('requirementId'),
        ]);
    }

}
