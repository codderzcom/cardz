<?php

namespace App\Contexts\Cards\Application\Controllers\Web\Card\Commands;

class AddAchievementRequest extends BaseCommandRequest
{
    public string $description;

    public function passedValidation(): void
    {
        $this->description = $this->input('description') ?: 'Random name';
    }
}
