<?php

namespace App\Contexts\Cards\Application\Controllers\Web\Card\Commands;

final class AddAchievementRequest extends BaseCommandRequest
{
    protected const RULES = [
        'description' => 'required',
        'requirementId' => 'required',
    ];

    protected const MESSAGES = [
        'requirementId.required' => 'requirementId required',
        'description.required' => 'achievement description required',
    ];

    public string $requirementId;
    public string $achievementDescription;

    public function passedValidation(): void
    {
        parent::passedValidation();
        $this->requirementId = $this->input('requirementId');
        $this->achievementDescription = $this->input('description');
    }
}
