<?php

namespace App\Contexts\Cards\Application\Controllers\Web\Card\Commands;

class AddAchievementRequest extends BaseCommandRequest
{
    public string $achievementDescription;

    public function passedValidation(): void
    {
        $this->achievementDescription = $this->input('description') ?: 'Random name';
    }
}
