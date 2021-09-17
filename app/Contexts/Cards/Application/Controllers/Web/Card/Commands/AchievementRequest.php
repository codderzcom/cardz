<?php

namespace App\Contexts\Cards\Application\Controllers\Web\Card\Commands;

final class AchievementRequest extends BaseCommandRequest
{
    protected const RULES = [
        'achievementId' => 'required',
        'description' => 'required',
    ];

    protected const MESSAGES = [
        'achievementId.required' => 'achievementId required',
        'description.required' => 'achievement description required',
    ];

    public string $achievementId;

    public string $achievementDescription;

    public function passedValidation(): void
    {
        parent::passedValidation();
        $this->achievementId = $this->input('achievementId');
        $this->achievementDescription = $this->input('description');
    }
}
