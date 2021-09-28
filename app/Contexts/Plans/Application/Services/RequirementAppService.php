<?php

namespace App\Contexts\Plans\Application\Services;

use App\Contexts\Plans\Application\Contracts\PlanRepositoryInterface;
use App\Contexts\Plans\Application\Contracts\RequirementRepositoryInterface;
use App\Contexts\Plans\Application\IntegrationEvents\RequirementAdded;
use App\Contexts\Plans\Application\IntegrationEvents\RequirementChanged;
use App\Contexts\Plans\Application\IntegrationEvents\RequirementRemoved;
use App\Contexts\Plans\Domain\Model\Plan\PlanId;
use App\Contexts\Plans\Domain\Model\Requirement\Requirement;
use App\Contexts\Plans\Domain\Model\Requirement\RequirementId;
use App\Shared\Contracts\ReportingBusInterface;
use App\Shared\Contracts\ServiceResultFactoryInterface;
use App\Shared\Contracts\ServiceResultInterface;
use App\Shared\Infrastructure\Support\ReportingServiceTrait;

class RequirementAppService
{
    use ReportingServiceTrait;

    public function __construct(
        private PlanRepositoryInterface $planRepository,
        private RequirementRepositoryInterface $requirementRepository,
        private ReportingBusInterface $reportingBus,
        private ServiceResultFactoryInterface $resultFactory,
    ) {
    }

    public function add(string $planId, string $description): ServiceResultInterface
    {
        $plan = $this->planRepository->take(PlanId::of($planId));
        if ($plan === null) {
            return $this->resultFactory->notFound("Plan $planId not found");
        }

        $requirement = Requirement::make(RequirementId::make(), $plan->planId, $description);
        $requirement->add();
        $this->requirementRepository->persist($requirement);

        $result = $this->resultFactory->ok($plan, new RequirementAdded($requirement->requirementId, $requirement->planId));
        return $this->reportResult($result, $this->reportingBus);
    }

    public function remove(string $planId, string $requirementId): ServiceResultInterface
    {
        $plan = $this->planRepository->take(PlanId::of($planId));
        if ($plan === null) {
            return $this->resultFactory->notFound("Plan $planId not found");
        }
        $requirement = $this->requirementRepository->take(RequirementId::of($requirementId));
        if ($requirement === null) {
            return $this->resultFactory->notFound("Requirement $requirementId not found");
        }

        if (!$requirement->planId->equals($plan->planId)) {
            return $this->resultFactory->notFound("Invalid requirement affiliation");
        }

        $requirement->remove();
        $this->requirementRepository->remove($requirement);

        $result = $this->resultFactory->ok($plan, new RequirementRemoved($requirement->requirementId, $requirement->planId));
        return $this->reportResult($result, $this->reportingBus);
    }

    public function change(string $planId, string $requirementId, string $description): ServiceResultInterface
    {
        $plan = $this->planRepository->take(PlanId::of($planId));
        if ($plan === null) {
            return $this->resultFactory->notFound("Plan $planId not found");
        }
        $requirement = $this->requirementRepository->take(RequirementId::of($requirementId));
        if ($requirement === null) {
            return $this->resultFactory->notFound("Requirement $requirementId not found");
        }

        if (!$requirement->planId->equals($plan->planId)) {
            return $this->resultFactory->notFound("Invalid requirement affiliation");
        }

        $requirement->change($description);
        $this->requirementRepository->persist($requirement);

        $result = $this->resultFactory->ok($plan, new RequirementChanged($requirement->requirementId, $plan->planId));
        return $this->reportResult($result, $this->reportingBus);
    }

}
