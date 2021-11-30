<?php

namespace Cardz\Core\Plans\Application\Services;

use Cardz\Core\Plans\Application\Commands\Requirement\AddRequirement;
use Cardz\Core\Plans\Application\Commands\Requirement\ChangeRequirement;
use Cardz\Core\Plans\Application\Commands\Requirement\RemoveRequirement;
use Cardz\Core\Plans\Domain\Model\Requirement\Requirement;
use Cardz\Core\Plans\Domain\Model\Requirement\RequirementId;
use Cardz\Core\Plans\Domain\Persistence\Contracts\PlanRepositoryInterface;
use Cardz\Core\Plans\Domain\Persistence\Contracts\RequirementRepositoryInterface;
use Cardz\Core\Plans\Infrastructure\Messaging\DomainEventBusInterface;

class RequirementAppService
{
    public function __construct(
        private PlanRepositoryInterface $planRepository,
        private RequirementRepositoryInterface $requirementRepository,
        private DomainEventBusInterface $domainEventBus,
    ) {
    }

    public function add(AddRequirement $command): RequirementId
    {
        $plan = $this->planRepository->take($command->getPlanId());
        return $this->releaseRequirement($plan->addRequirement($command->getRequirementId(), $command->getDescription()));
    }

    public function remove(RemoveRequirement $command): RequirementId
    {
        $requirement = $this->requirementRepository->take($command->getRequirementId());
        return $this->releaseRequirement($requirement->remove());
    }

    public function change(ChangeRequirement $command): RequirementId
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
