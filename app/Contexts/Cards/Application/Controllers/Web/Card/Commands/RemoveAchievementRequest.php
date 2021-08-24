<?php

namespace App\Contexts\Cards\Application\Controllers\Web\Card\Commands;

use App\Contexts\Cards\Domain\Model\Card\AchievementId;

class RemoveAchievementRequest extends BaseCommandRequest
{
    use ForSpecificCardTrait;

    public function getAchievementId(): AchievementId
    {
        return new AchievementId($this->route('achievementId'));
    }
}
