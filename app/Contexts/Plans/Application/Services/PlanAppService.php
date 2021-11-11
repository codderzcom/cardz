<?php

namespace App\Contexts\Plans\Application\Services;

use App\Contexts\Plans\Application\Commands\Plan\AddPlan;
use App\Contexts\Plans\Application\Commands\Plan\ChangePlanDescription;
use App\Contexts\Plans\Application\Commands\Plan\LaunchPlan;
use App\Contexts\Plans\Application\Commands\Plan\PlanCommandInterface;
use App\Contexts\Plans\Application\Commands\Plan\StopPlan;
use App\Contexts\Plans\Domain\Model\Plan\Plan;
use App\Contexts\Plans\Domain\Model\Plan\PlanId;
use App\Contexts\Plans\Domain\Persistence\Contracts\PlanRepositoryInterface;
use App\Contexts\Plans\Domain\Persistence\Contracts\WorkspaceRepositoryInterface;
use App\Contexts\Plans\Infrastructure\Messaging\DomainEventBusInterface;

class PlanAppService
{

    public function __construct(
        private PlanRepositoryInterface $planRepository,
        private WorkspaceRepositoryInterface $workspaceRepository,
        private DomainEventBusInterface $domainEventBus,
    ) {
    }

    public function add(AddPlan $command): PlanId
    {
        $workspace = $this->workspaceRepository->take($command->getWorkspaceId());
        return $this->release($workspace->addPlan($command->getPlanId(), $command->getDescription()));
    }

    public function launch(LaunchPlan $command): PlanId
    {
        $plan = $this->getPlan($command);
        return $this->release($plan->launch());
    }

    public function stop(StopPlan $command): PlanId
    {
        $plan = $this->getPlan($command);
        return $this->release($plan->stop());
    }

    public function archive(AddPlan $command): PlanId
    {
        $plan = $this->getPlan($command);
        return $this->release($plan->archive());
    }

    public function changeDescription(ChangePlanDescription $command): PlanId
    {
        $plan = $this->getPlan($command);
        return $this->release($plan->changeDescription($command->getDescription()));
    }

    private function release(Plan $plan): PlanId
    {
        $this->planRepository->persist($plan);
        $this->domainEventBus->publish(...$plan->releaseEvents());
        return $plan->planId;
    }

    private function getPlan(PlanCommandInterface $command): Plan
    {
        return $this->planRepository->take($command->getPlanId());
    }
}
