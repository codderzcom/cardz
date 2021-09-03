<?php

namespace App\Contexts\Plans\Domain\Services;

use App\Contexts\Plans\Domain\Model\Plan\Plan;
use App\Contexts\Plans\Domain\Model\Requirement\RequirementCollection;

class AchievementCalculationService
{
    public function getRequirements(
        Plan $plan,
        RequirementCollection $required,
        RequirementCollection $achieved,
    ): RequirementCollection {
        $strategy = $this->selectAchievementFilterStrategy($plan);
        return $strategy($required, $achieved);
    }

    private function selectAchievementFilterStrategy(Plan $plan): callable
    {
        //ToDo: выбрать стратегию применения достижений в зависимости от программы ляльности
        return [$this, 'simpleRequirementsFilter'];
    }

    public function isPlanCompleted(Plan $plan, RequirementCollection $required, RequirementCollection $achieved): bool
    {
        $strategy = $this->selectRequirementFulfillmentStrategy($plan);
        return $strategy($required, $achieved);
    }

    private function selectRequirementFulfillmentStrategy(Plan $plan): callable
    {
        //ToDo: выбрать стратегию завершённости программы
        return [$this, 'simpleCompletenessCalculationStrategy'];
    }

    private function simpleRequirementsFilter(RequirementCollection $required, RequirementCollection $achieved): RequirementCollection
    {
        $filtered = $required->copy();
        foreach ($required as $key => $requiredItem) {
            foreach ($achieved as $achievedItem) {
                if ((string) $requiredItem->requirementId === (string) $achievedItem->requirementId) {
                    unset($filtered[$key]);
                    break;
                }
            }
        }
        return $filtered->copy();
    }

    private function simpleCompletenessCalculationStrategy(RequirementCollection $required, RequirementCollection $achieved): bool
    {
        $filtered = $required->copy();
        foreach ($required as $key => $requiredItem) {
            foreach ($achieved as $achievedItem) {
                if ((string) $requiredItem->requirementId === (string) $achievedItem->requirementId) {
                    unset($filtered[$key]);
                    break;
                }
            }
        }
        return $filtered->length() <= 0;
    }
}
