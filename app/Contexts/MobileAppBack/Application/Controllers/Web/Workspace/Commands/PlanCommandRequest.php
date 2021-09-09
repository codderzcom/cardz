<?php

namespace App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\Commands;

class PlanCommandRequest extends BaseCommandRequest
{
    protected const RULES = [
        'planId' => 'required',
    ];

    protected const MESSAGES = [
        'planId.required' => 'planId required',
    ];

    public string $planId;

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
        $this->planId = $this->input('planId');
    }

    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();
        $this->merge([
            'planId' => $this->route('planId'),
        ]);
    }
}
