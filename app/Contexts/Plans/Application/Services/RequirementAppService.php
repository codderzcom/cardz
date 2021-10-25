<?php

namespace App\Contexts\Plans\Application\Services;

use App\Contexts\Plans\Application\Commands\Requirement\AddRequirementCommandInterface;
use App\Contexts\Plans\Application\Commands\Requirement\ChangeRequirementCommandInterface;
use App\Contexts\Plans\Application\Commands\Requirement\RemoveRequirementCommandInterface;
use App\Contexts\Plans\Domain\Model\Requirement\Requirement;
use App\Contexts\Plans\Domain\Model\Requirement\RequirementId;
use App\Contexts\Plans\Domain\Persistence\Contracts\PlanRepositoryInterface;
use App\Contexts\Plans\Domain\Persistence\Contracts\RequirementRepositoryInterface;
use App\Contexts\Plans\Infrastructure\Messaging\DomainEventBusInterface;

class RequirementAppService
{
    public function __construct(
        private PlanRepositoryInterface $planRepository,
        private RequirementRepositoryInterface $requirementRepository,
        private DomainEventBusInterface $domainEventBus,
    ) {
    }

    public function add(AddRequirementCommandInterface $command): RequirementId
    {
        $plan = $this->planRepository->take($command->getPlanId());
        return $this->releaseRequirement($plan->addRequirement($command->getRequirementId(), $command->getDescription()));
    }

    public function remove(RemoveRequirementCommandInterface $command): RequirementId
    {
        $requirement = $this->requirementRepository->take($command->getRequirementId());
        return $this->releaseRequirement($requirement->remove());
    }

    public function change(ChangeRequirementCommandInterface $command): RequirementId
    {
        $requirement = $this->requirementRepository->take($command->getRequirementId());
        return $this->releaseRequirement($requirement->change($command->getDescription())
        );
    }

    private function releaseRequirement(Requirement $requirement): RequirementId
    {
        $this->requirementRepository->persist($requirement);
        $this->domainEventBus->publish(...$requirement->releaseEvents());
        return $requirement->requirementId;
    }
}
