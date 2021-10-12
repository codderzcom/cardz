<?php

namespace App\Contexts\Plans\Application\Services;

use App\Contexts\Plans\Application\Commands\Requirement\AddRequirementCommandInterface;
use App\Contexts\Plans\Application\Commands\Requirement\ChangeRequirementCommandInterface;
use App\Contexts\Plans\Application\Commands\Requirement\RemoveRequirementCommandInterface;
use App\Contexts\Plans\Application\Commands\Requirement\RequirementCommandInterface;
use App\Contexts\Plans\Domain\Model\Plan\Plan;
use App\Contexts\Plans\Domain\Model\Requirement\Requirement;
use App\Contexts\Plans\Domain\Model\Requirement\RequirementId;
use App\Contexts\Plans\Infrastructure\Messaging\DomainEventBusInterface;
use App\Contexts\Plans\Infrastructure\Persistence\Contracts\PlanRepositoryInterface;
use App\Contexts\Plans\Infrastructure\Persistence\Contracts\RequirementRepositoryInterface;

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
        $plan = $this->plan($command);
        return $this->releaseRequirement($plan->addRequirement($command->getRequirementId(), $command->getDescription()));
    }

    public function remove(RemoveRequirementCommandInterface $command): RequirementId
    {
        $requirement = $this->requirement($command);
        return $this->releaseRequirement($requirement->remove());
    }

    public function change(ChangeRequirementCommandInterface $command): RequirementId
    {
        $requirement = $this->requirement($command);
        return $this->releaseRequirement($requirement->change($command->getDescription())
        );
    }

    private function releaseRequirement(Requirement $requirement): RequirementId
    {
        $this->requirementRepository->persist($requirement);
        $this->domainEventBus->publish(...$requirement->releaseEvents());
        return $requirement->requirementId;
    }

    private function requirement(RequirementCommandInterface $command): Requirement
    {
        return $this->requirementRepository->take($command->getRequirementId());
    }

    private function plan(AddRequirementCommandInterface $command): Plan
    {
        return $this->planRepository->take($command->getPlanId());
    }
}
