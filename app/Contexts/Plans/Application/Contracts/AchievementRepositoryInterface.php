<?php

namespace App\Contexts\Plans\Application\Contracts;

use App\Contexts\Plans\Domain\Model\Achievement\Achievement;
use App\Contexts\Plans\Domain\Model\Achievement\AchievementCollection;
use App\Contexts\Plans\Domain\Model\Achievement\AchievementId;
use App\Contexts\Plans\Domain\Model\Achievement\AchievementIdCollection;
use App\Contexts\Plans\Domain\Model\Plan\PlanId;

interface AchievementRepositoryInterface
{
    public function persist(?Achievement $achievement): void;

    public function take(AchievementId $achievementId): ?Achievement;

    public function takeByAchievementIds(AchievementIdCollection $achievementIds): AchievementCollection;

    public function takeByPlanId(PlanId $planId): AchievementCollection;
}
