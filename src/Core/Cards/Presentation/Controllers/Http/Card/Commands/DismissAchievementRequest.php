<?php

namespace Cardz\Core\Cards\Presentation\Controllers\Http\Card\Commands;

use Cardz\Core\Cards\Application\Commands\DismissAchievement;

final class DismissAchievementRequest extends BaseCommandRequest
{
    protected const RULES = [
        'achievementId' => 'required',
    ];

    protected const MESSAGES = [
        'achievementId.required' => 'achievementId required',
    ];

    public string $achievementId;

    public function passedValidation(): void
    {
        parent::passedValidation();
        $this->achievementId = $this->input('achievementId');
    }

    public function toCommand(): DismissAchievement
    {
        return DismissAchievement::of($this->cardId, $this->achievementId);
    }

}
