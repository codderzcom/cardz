<?php

namespace App\Contexts\Plans\Application\Services;

use App\Contexts\Plans\Application\Commands\Requirement\AddRequirementCommandInterface;
use App\Contexts\Plans\Application\Commands\Requirement\ChangeRequirementCommandInterface;
use App\Contexts\Plans\Application\Commands\Requirement\RemoveRequirementCommandInterface;
use App\Contexts\Plans\Application\Exceptions\PlanNotFoundException;
use App\Contexts\Plans\Application\Exceptions\RequirementNotFoundException;
use App\Contexts\Plans\Domain\Model\Requirement\Requirement;
use App\Contexts\Plans\Domain\Model\Requirement\RequirementId;
use App\Contexts\Plans\Infrastructure\Messaging\DomainEventBusInterface;
use App\Contexts\Plans\Infrastructure\Persistence\Contracts\PlanRepositoryInterface;
use App\Contexts\Plans\Infrastructure\Persistence\Contracts\RequirementRepositoryInterface;
use App\Shared\Contracts\Commands\CommandBusInterface;
use App\Shared\Infrastructure\CommandHandling\CommandHandlerFactoryTrait;

class RequirementAppService
{
    use CommandHandlerFactoryTrait;

    public function __construct(
        private PlanRepositoryInterface $planRepository,
        private RequirementRepositoryInterface $requirementRepository,
        private DomainEventBusInterface $domainEventBus,
        private CommandBusInterface $commandBus,
    ) {
    }

    public function registerHandlers(): void
    {
        $this->commandBus->registerHandlers(
            $this->makeHandlerFor(AddRequirementCommandInterface::class, 'add'),
            $this->makeHandlerFor(RemoveRequirementCommandInterface::class, 'remove'),
            $this->makeHandlerFor(ChangeRequirementCommandInterface::class, 'change'),
        );
    }

    /**
     * @throws PlanNotFoundException
     */
    public function add(AddRequirementCommandInterface $command): RequirementId
    {
        $plan = $this->planRepository->take($command->getPlanId());
        if ($plan === null) {
            throw new PlanNotFoundException("Plan id {$command->getPlanId()}");
        }

        $requirement = $plan->addRequirement($command->getRequirementId(), $command->getDescription());
        return $this->releaseRequirement($requirement);
    }

    /**
     * @throws RequirementNotFoundException
     */
    public function remove(RemoveRequirementCommandInterface $command): RequirementId
    {
        $requirement = $this->requirementRepository->take($command->getRequirementId());
        if ($requirement === null) {
            throw new RequirementNotFoundException();
        }

        $requirement->remove();
        return $this->releaseRequirement($requirement);
    }

    /**
     * @throws RequirementNotFoundException
     */
    public function change(ChangeRequirementCommandInterface $command): RequirementId
    {
        $requirement = $this->requirementRepository->take($command->getRequirementId());
        if ($requirement === null) {
            throw new RequirementNotFoundException();
        }

        $requirement->change($command->getDescription());
        return $this->releaseRequirement($requirement);
    }

    private function releaseRequirement(Requirement $requirement): RequirementId
    {
        $this->requirementRepository->persist($requirement);
        $this->domainEventBus->publish(...$requirement->releaseEvents());
        return $requirement->requirementId;
    }
}
