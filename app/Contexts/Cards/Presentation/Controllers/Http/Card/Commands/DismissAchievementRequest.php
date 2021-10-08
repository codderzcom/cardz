<?php

namespace App\Contexts\Cards\Presentation\Controllers\Http\Card\Commands;

final class DismissAchievementRequest extends BaseCommandRequest
{
    protected const RULES = [
        'achievementId' => 'required',
    ];

    protected const MESSAGES = [
        'achievementId.required' => 'achievementId required',
    ];

    public string $achievementId;

    public string $achievementDescription;

    public function passedValidation(): void
    {
        parent::passedValidation();
        $this->achievementId = $this->input('achievementId');
    }
}
