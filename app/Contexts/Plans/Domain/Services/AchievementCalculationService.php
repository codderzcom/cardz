<?php

namespace App\Contexts\Plans\Domain\Services;

use App\Contexts\Plans\Domain\Model\Achievement\Achievement;
use App\Contexts\Plans\Domain\Model\Achievement\AchievementCollection;
use App\Contexts\Plans\Domain\Model\Plan\Plan;

class AchievementCalculationService
{
    /**
     * @return Achievement[]
     */
    public function getRequiredAchievements(
        Plan $plan,
        AchievementCollection $required,
        AchievementCollection $achieved,
    ): array {
        $this->selectAchievementStrategy($plan);
    }

    private function selectAchievementStrategy(Plan $plan)
    {
        //ToDo: выбрать стратегию применения достижений в зависимости от программы ляльности
        return;
    }

    private function simpleAchievementsFilter(AchievementCollection $required, AchievementCollection $achieved): AchievementCollection
    {
        return $required->copy();
    }
}
