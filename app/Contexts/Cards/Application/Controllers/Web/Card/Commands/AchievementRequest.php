<?php

namespace App\Contexts\Cards\Application\Controllers\Web\Card\Commands;

final class AchievementRequest extends BaseCommandRequest
{
    protected const RULES = [
        'description' => 'required',
    ];

    protected const MESSAGES = [
        'description.required' => 'achievement description required',
    ];

    public string $achievementDescription;

    public function passedValidation(): void
    {
        parent::passedValidation();
        $this->achievementDescription = $this->input('description');
    }
}
