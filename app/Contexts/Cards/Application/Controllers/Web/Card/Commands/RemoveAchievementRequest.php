<?php

namespace App\Contexts\Cards\Application\Controllers\Web\Card\Commands;

class RemoveAchievementRequest extends BaseCommandRequest
{
    protected const RULES = [
        'requirementId' => 'required',
    ];

    protected const MESSAGES = [
        'requirementId.required' => 'requirementId required',
    ];

    public string $requirementId;

    public function passedValidation(): void
    {
        parent::passedValidation();
        $this->requirementId = $this->input('requirementId');
    }

    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();
        $this->merge([
            'requirementId' => $this->route('requirementId'),
        ]);
    }
}
