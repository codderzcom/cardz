<?php

namespace App\Contexts\Plans\Application\Controllers\Web\Achievement\Commands;

class ChangeAchievementRequest extends BaseCommandRequest
{
    public string $description;

    public function passedValidation(): void
    {
        $this->description = $this->input('description') ?: 'Error';
    }
}
