<?php

namespace App\Contexts\Plans\Application\Contracts;

use App\Contexts\Plans\Domain\Model\Achievement\Achievement;
use App\Contexts\Plans\Domain\Model\Achievement\AchievementId;

interface AchievementRepositoryInterface
{
    public function take(AchievementId $achievementId): ?Achievement;

    public function save(Achievement $achievement): void;

}
