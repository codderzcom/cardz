<?php

namespace App\Contexts\Cards\Presentation\Controllers\Http\Card\Commands;

use App\Contexts\Cards\Application\Commands\NoteAchievement;

final class NoteAchievementRequest extends BaseCommandRequest
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

    public function toCommand(): NoteAchievement
    {
        return NoteAchievement::of($this->cardId, $this->achievementId, $this->achievementDescription);
    }
}
