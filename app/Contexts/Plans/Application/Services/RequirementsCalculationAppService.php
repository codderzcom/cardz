<?php

namespace App\Contexts\Plans\Application\Services;

use App\Contexts\Plans\Application\Contracts\AchievementRepositoryInterface;
use App\Contexts\Plans\Application\Contracts\PlanRepositoryInterface;
use App\Contexts\Plans\Domain\Model\Achievement\Achievement;
use App\Contexts\Plans\Domain\Model\Achievement\AchievementCollection;
use App\Contexts\Plans\Domain\Model\Achievement\AchievementId;
use App\Contexts\Plans\Domain\Model\Achievement\AchievementIdCollection;
use App\Contexts\Plans\Domain\Model\Plan\PlanId;
use App\Contexts\Plans\Domain\Model\Shared\Description;
use App\Contexts\Plans\Domain\Services\AchievementCalculationService;
use App\Contexts\Shared\Contracts\ServiceResultFactoryInterface;
use App\Contexts\Shared\Contracts\ServiceResultInterface;
use App\Contexts\Shared\Infrastructure\Support\ReportingServiceTrait;

class RequirementsCalculationAppService
{
    use ReportingServiceTrait;

    public function __construct(
        private PlanRepositoryInterface $planRepository,
        private AchievementRepositoryInterface $achievementRepository,
        private AchievementCalculationService $achievementCalculationService,
        private ServiceResultFactoryInterface $resultFactory,
    ) {
    }

    public function restOfRequirements(string $planId, string ...$requirementIds): ServiceResultInterface
    {
        $plan = $this->planRepository->take(PlanId::of($planId));
        if ($plan === null) {
            return $this->resultFactory->notFound("$planId not found");
        }

        $achievementIds = AchievementIdCollection::ofIds(...$requirementIds);
        $achievedRequirements = $this->achievementRepository->takeByAchievementIds($achievementIds);
        $planRequirements = $this->achievementRepository->takeByPlanId($plan->planId);
        $requiredRequirements = $this->achievementCalculationService->getRequiredAchievements(
            $plan,
            $planRequirements,
            $achievedRequirements
        );

        return $this->resultFactory->ok($requiredRequirements);
    }

    public function isSatisfiedByRequirements(string $planId, string ...$requirementIds): ServiceResultInterface
    {
        $plan = $this->planRepository->take(PlanId::of($planId));
        if ($plan === null) {
            return $this->resultFactory->notFound("$planId not found");
        }


        $achievementIds = AchievementIdCollection::ofIds(...$requirementIds);
        $achievedRequirements = $this->achievementRepository->takeByAchievementIds($achievementIds);
        $planRequirements = $this->achievementRepository->takeByPlanId($plan->planId);
        $isSatisfied = $this->achievementCalculationService->isPlanCompleted(
            $plan,
            $planRequirements,
            $achievedRequirements
        );

        return $this->resultFactory->ok($isSatisfied);
    }

}
