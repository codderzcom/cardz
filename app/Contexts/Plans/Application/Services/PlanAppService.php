<?php

namespace App\Contexts\Plans\Application\Services;

use App\Contexts\Plans\Application\Commands\Plan\AddPlanCommandInterface;
use App\Contexts\Plans\Application\Commands\Plan\ChangePlanDescriptionCommandInterface;
use App\Contexts\Plans\Application\Commands\Plan\LaunchPlanCommandInterface;
use App\Contexts\Plans\Application\Commands\Plan\PlanCommandInterface;
use App\Contexts\Plans\Application\Commands\Plan\StopPlanCommandInterface;
use App\Contexts\Plans\Domain\Model\Plan\Plan;
use App\Contexts\Plans\Domain\Model\Plan\PlanId;
use App\Contexts\Plans\Domain\Model\Plan\Workspace;
use App\Contexts\Plans\Infrastructure\Messaging\DomainEventBusInterface;
use App\Contexts\Plans\Infrastructure\Persistence\Contracts\PlanRepositoryInterface;
use App\Contexts\Plans\Infrastructure\Persistence\Contracts\WorkspaceRepositoryInterface;

class PlanAppService
{

    public function __construct(
        private PlanRepositoryInterface $planRepository,
        private WorkspaceRepositoryInterface $workspaceRepository,
        private DomainEventBusInterface $domainEventBus,
    ) {
    }

    public function add(AddPlanCommandInterface $command): PlanId
    {
        $workspace = $this->workspace($command);
        return $this->releasePlan($workspace->addPlan($command->getPlanId(), $command->getDescription()));
    }

    public function launch(LaunchPlanCommandInterface $command): PlanId
    {
        $plan = $this->plan($command);
        return $this->releasePlan($plan->launch());
    }

    public function stop(StopPlanCommandInterface $command): PlanId
    {
        $plan = $this->plan($command);
        return $this->releasePlan($plan->stop());
    }

    public function archive(AddPlanCommandInterface $command): PlanId
    {
        $plan = $this->plan($command);
        return $this->releasePlan($plan->archive());
    }

    public function changeDescription(ChangePlanDescriptionCommandInterface $command): PlanId
    {
        $plan = $this->plan($command);
        return $this->releasePlan($plan->changeDescription($command->getDescription()));
    }

    private function releasePlan(Plan $plan): PlanId
    {
        $this->planRepository->persist($plan);
        $this->domainEventBus->publish(...$plan->releaseEvents());
        return $plan->planId;
    }

    private function plan(PlanCommandInterface $command): Plan
    {
        return $this->planRepository->take($command->getPlanId());
    }

    private function workspace(AddPlanCommandInterface $command): Workspace
    {
        return $this->workspaceRepository->take($command->getWorkspaceId());
    }

}
