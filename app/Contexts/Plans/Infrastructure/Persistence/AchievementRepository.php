<?php

namespace App\Contexts\Plans\Infrastructure\Persistence;

use App\Contexts\Plans\Application\Contracts\AchievementRepositoryInterface;
use App\Contexts\Plans\Domain\Model\Achievement\Achievement;
use App\Contexts\Plans\Domain\Model\Achievement\AchievementId;

class AchievementRepository implements AchievementRepositoryInterface
{
    public function take(AchievementId $achievementId): ?Achievement
    {
        // TODO: Implement take() method.
        return null;
    }

    public function save(Achievement $achievement): void
    {
        // TODO: Implement save() method.
    }

}
