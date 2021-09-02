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
        $strategy = $this->selectAchievementFilterStrategy($plan);
        return $strategy($required, $achieved);
    }

    public function isPlanCompleted(Plan $plan, AchievementCollection $required, AchievementCollection $achieved): bool
    {
        $strategy = $this->selectAchievementFulfillmentStrategy($plan);
        return $strategy($required, $achieved);
    }

    private function selectAchievementFilterStrategy(Plan $plan): callable
    {
        //ToDo: выбрать стратегию применения достижений в зависимости от программы ляльности
        return [$this, 'simpleCompletenessCalculationStrategy'];
    }

    private function selectAchievementFulfillmentStrategy(Plan $plan): callable
    {
        //ToDo: выбрать стратегию завершённости программы
        return [$this, 'simpleAchievementsFilter'];
    }

    private function simpleAchievementsFilter(AchievementCollection $required, AchievementCollection $achieved): AchievementCollection
    {
        $filtered = $required->copy();
        foreach ($required as $key => $requiredItem) {
            foreach ($achieved as $achievedItem) {
                if ((string) $requiredItem->achievementId === (string) $achievedItem->achievementId) {
                    unset($filtered[$key]);
                    break;
                }
            }
        }
        return $filtered;
    }

    private function simpleCompletenessCalculationStrategy(AchievementCollection $required, AchievementCollection $achieved): bool
    {
        $filtered = $required->copy();
        foreach ($required as $key => $requiredItem) {
            foreach ($achieved as $achievedItem) {
                if ((string) $requiredItem->achievementId === (string) $achievedItem->achievementId) {
                    unset($filtered[$key]);
                    break;
                }
            }
        }
        return $filtered->length() <= 0;
    }
}
