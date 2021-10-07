<?php

namespace App\Contexts\Plans\Application\Services;

use App\Contexts\Plans\Application\Commands\Plan\AddPlanCommandInterface;
use App\Contexts\Plans\Application\Commands\Plan\ChangePlanDescriptionCommandInterface;
use App\Contexts\Plans\Application\Commands\Plan\LaunchPlanCommandInterface;
use App\Contexts\Plans\Application\Commands\Plan\StopPlanCommandInterface;
use App\Contexts\Plans\Application\Exceptions\PlanNotFoundException;
use App\Contexts\Plans\Application\Exceptions\WorkspaceNotFoundException;
use App\Contexts\Plans\Domain\Model\Plan\Plan;
use App\Contexts\Plans\Domain\Model\Plan\PlanId;
use App\Contexts\Plans\Infrastructure\Messaging\DomainEventBusInterface;
use App\Contexts\Plans\Infrastructure\Persistence\Contracts\PlanRepositoryInterface;
use App\Contexts\Plans\Infrastructure\Persistence\Contracts\WorkspaceRepositoryInterface;
use App\Shared\Contracts\Commands\CommandBusInterface;
use App\Shared\Infrastructure\CommandHandling\CommandHandlerFactoryTrait;

class PlanAppService
{
    use CommandHandlerFactoryTrait;

    public function __construct(
        private PlanRepositoryInterface $planRepository,
        private WorkspaceRepositoryInterface $workspaceRepository,
        private DomainEventBusInterface $domainEventBus,
        private CommandBusInterface $commandBus,
    ) {
    }

    public function registerHandlers(): void
    {
        $this->commandBus->registerHandlers(
            $this->makeHandlerFor(AddPlanCommandInterface::class, 'add'),
            $this->makeHandlerFor(LaunchPlanCommandInterface::class, 'launch'),
            $this->makeHandlerFor(StopPlanCommandInterface::class, 'stop'),
            $this->makeHandlerFor(AddPlanCommandInterface::class, 'archive'),
            $this->makeHandlerFor(ChangePlanDescriptionCommandInterface::class, 'changeDescription'),
        );
    }

    /**
     * @throws WorkspaceNotFoundException
     */
    public function add(AddPlanCommandInterface $command): PlanId
    {
        $workspace = $this->workspaceRepository->take($command->getWorkspaceId());
        if ($workspace === null) {
            throw new WorkspaceNotFoundException("Workspace id {$command->getWorkspaceId()}");
        }

        $plan = $workspace->addPlan($command->getPlanId(), $command->getDescription());
        return $this->releasePlan($plan);
    }

    /**
     * @throws PlanNotFoundException
     */
    public function launch(LaunchPlanCommandInterface $command): PlanId
    {
        $plan = $this->planRepository->take($command->getPlanId());
        if ($plan === null) {
            throw new PlanNotFoundException("Plan id {$command->getPlanId()}");
        }

        $plan->launch();
        return $this->releasePlan($plan);
    }

    /**
     * @throws PlanNotFoundException
     */
    public function stop(StopPlanCommandInterface $command): PlanId
    {
        $plan = $this->planRepository->take($command->getPlanId());
        if ($plan === null) {
            throw new PlanNotFoundException("Plan id {$command->getPlanId()}");
        }

        $plan->stop();
        return $this->releasePlan($plan);
    }

    /**
     * @throws PlanNotFoundException
     */
    public function archive(AddPlanCommandInterface $command): PlanId
    {
        $plan = $this->planRepository->take($command->getPlanId());
        if ($plan === null) {
            throw new PlanNotFoundException("Plan id {$command->getPlanId()}");
        }

        $plan->archive();
        return $this->releasePlan($plan);
    }

    /**
     * @throws PlanNotFoundException
     */
    public function changeDescription(ChangePlanDescriptionCommandInterface $command): PlanId
    {
        $plan = $this->planRepository->take($command->getPlanId());
        if ($plan === null) {
            throw new PlanNotFoundException("Plan id {$command->getPlanId()}");
        }

        $plan->changeDescription($command->getDescription());
        return $this->releasePlan($plan);
    }

    private function releasePlan(Plan $plan): PlanId
    {
        $this->planRepository->persist($plan);
        $this->domainEventBus->publish(...$plan->releaseEvents());
        return $plan->planId;
    }

}
