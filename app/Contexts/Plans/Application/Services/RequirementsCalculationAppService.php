<?php

namespace App\Contexts\Plans\Application\Services;

use App\Contexts\Plans\Application\Contracts\PlanRepositoryInterface;
use App\Contexts\Plans\Application\Contracts\RequirementRepositoryInterface;
use App\Contexts\Plans\Domain\Model\Plan\PlanId;
use App\Contexts\Plans\Domain\Model\Requirement\RequirementIdCollection;
use App\Contexts\Plans\Domain\Services\AchievementCalculationService;
use App\Contexts\Shared\Contracts\ServiceResultFactoryInterface;
use App\Contexts\Shared\Contracts\ServiceResultInterface;
use App\Contexts\Shared\Infrastructure\Support\ReportingServiceTrait;

class RequirementsCalculationAppService
{
    use ReportingServiceTrait;

    public function __construct(
        private PlanRepositoryInterface $planRepository,
        private RequirementRepositoryInterface $requirementRepository,
        private AchievementCalculationService $achievementCalculationService,
        private ServiceResultFactoryInterface $resultFactory,
    ) {
    }

    public function restOfRequirements(string $planId, string ...$achievedRequirementIds): ServiceResultInterface
    {
        $plan = $this->planRepository->take(PlanId::of($planId));
        if ($plan === null) {
            return $this->resultFactory->notFound("$planId not found");
        }

        $achievedRequirementIdCollection = RequirementIdCollection::ofIds(...$achievedRequirementIds);
        $achievedRequirements = $this->requirementRepository->takeByRequirementIds($achievedRequirementIdCollection);
        $planRequirements = $this->requirementRepository->takeByPlanId($plan->planId);
        $requiredRequirements = $this->achievementCalculationService->getRequirements(
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

        $requirementIdCollection = RequirementIdCollection::ofIds(...$requirementIds);
        $achievedRequirements = $this->requirementRepository->takeByRequirementIds($requirementIdCollection);
        $planRequirements = $this->requirementRepository->takeByPlanId($plan->planId);
        $isSatisfied = $this->achievementCalculationService->isPlanCompleted(
            $plan,
            $planRequirements,
            $achievedRequirements
        );

        return $this->resultFactory->ok($isSatisfied);
    }

}
