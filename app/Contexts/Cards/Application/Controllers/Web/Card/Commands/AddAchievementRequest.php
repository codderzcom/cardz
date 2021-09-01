<?php

namespace App\Contexts\Cards\Application\Controllers\Web\Card\Commands;

class AddAchievementRequest extends BaseCommandRequest
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
        $this->achievementDescription = $this->input('description');
    }
}
