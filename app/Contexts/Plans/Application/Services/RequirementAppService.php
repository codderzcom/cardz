<?php

namespace App\Contexts\Plans\Application\Services;

use App\Contexts\Plans\Application\Contracts\RequirementRepositoryInterface;
use App\Contexts\Plans\Application\IntegrationEvents\RequirementAdded;
use App\Contexts\Plans\Application\IntegrationEvents\RequirementChanged;
use App\Contexts\Plans\Application\IntegrationEvents\RequirementRemoved;
use App\Contexts\Plans\Domain\Model\Plan\PlanId;
use App\Contexts\Plans\Domain\Model\Requirement\Requirement;
use App\Contexts\Plans\Domain\Model\Requirement\RequirementId;
use App\Contexts\Plans\Domain\Model\Shared\Description;
use App\Contexts\Shared\Contracts\ReportingBusInterface;
use App\Contexts\Shared\Contracts\ServiceResultFactoryInterface;
use App\Contexts\Shared\Contracts\ServiceResultInterface;
use App\Contexts\Shared\Infrastructure\Support\ReportingServiceTrait;

class RequirementAppService
{
    use ReportingServiceTrait;

    public function __construct(
        private RequirementRepositoryInterface $requirementRepository,
        private ReportingBusInterface $reportingBus,
        private ServiceResultFactoryInterface $resultFactory,
    ) {
    }

    public function add(string $planId, string $description): ServiceResultInterface
    {
        $requirement = Requirement::make(
            RequirementId::make(),
            PlanId::of($planId),
            Description::of($description)
        );

        $requirement->add();
        $this->requirementRepository->persist($requirement);

        $result = $this->resultFactory->ok($requirement, new RequirementAdded($requirement->requirementId));
        return $this->reportResult($result, $this->reportingBus);
    }

    public function remove(string $requirementId): ServiceResultInterface
    {
        $requirement = $this->requirementRepository->take(RequirementId::of($requirementId));
        if ($requirement === null) {
            return $this->resultFactory->notFound("$requirementId not found");
        }

        $requirement->remove();
        $this->requirementRepository->persist($requirement);

        $result = $this->resultFactory->ok($requirement, new RequirementRemoved($requirement->requirementId));
        return $this->reportResult($result, $this->reportingBus);
    }

    public function change(string $requirementId, string $description): ServiceResultInterface
    {
        $requirement = $this->requirementRepository->take(RequirementId::of($requirementId));
        if ($requirement === null) {
            return $this->resultFactory->notFound("$requirementId not found");
        }

        $requirement->change(Description::of($description));
        $this->requirementRepository->persist($requirement);

        $result = $this->resultFactory->ok($requirement, new RequirementChanged($requirement->requirementId));
        return $this->reportResult($result, $this->reportingBus);
    }
}
