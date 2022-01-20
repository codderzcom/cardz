<?php

namespace Cardz\Core\Plans\Application\Services;

use Cardz\Core\Plans\Application\Commands\Plan\AddPlan;
use Cardz\Core\Plans\Application\Commands\Plan\ArchivePlan;
use Cardz\Core\Plans\Application\Commands\Plan\ChangePlanProfile;
use Cardz\Core\Plans\Application\Commands\Plan\LaunchPlan;
use Cardz\Core\Plans\Application\Commands\Plan\PlanCommandInterface;
use Cardz\Core\Plans\Application\Commands\Plan\StopPlan;
use Cardz\Core\Plans\Domain\Exceptions\PlanNotFoundExceptionInterface;
use Cardz\Core\Plans\Domain\Exceptions\WorkspaceNotFoundExceptionInterface;
use Cardz\Core\Plans\Domain\Model\Plan\Plan;
use Cardz\Core\Plans\Domain\Model\Plan\PlanId;
use Cardz\Core\Plans\Domain\Persistence\Contracts\PlanRepositoryInterface;
use Cardz\Core\Plans\Domain\Persistence\Contracts\WorkspaceRepositoryInterface;
use Cardz\Core\Plans\Infrastructure\Messaging\DomainEventBusInterface;

class PlanAppService
{

    public function __construct(
        private PlanRepositoryInterface $planRepository,
        private WorkspaceRepositoryInterface $workspaceRepository,
        private DomainEventBusInterface $domainEventBus,
    ) {
    }

    /**
     * @throws WorkspaceNotFoundExceptionInterface
     */
    public function add(AddPlan $command): PlanId
    {
        $workspace = $this->workspaceRepository->take($command->getWorkspaceId());
        return $this->release($workspace->addPlan($command->getPlanId(), $command->getProfile()));
    }

    /**
     * @throws PlanNotFoundExceptionInterface
     */
    public function launch(LaunchPlan $command): PlanId
    {
        $plan = $this->getPlan($command);
        return $this->release($plan->launch($command->getExpirationDate()));
    }

    /**
     * @throws PlanNotFoundExceptionInterface
     */
    public function stop(StopPlan $command): PlanId
    {
        $plan = $this->getPlan($command);
        return $this->release($plan->stop());
    }

    /**
     * @throws PlanNotFoundExceptionInterface
     */
    public function archive(ArchivePlan $command): PlanId
    {
        $plan = $this->getPlan($command);
        return $this->release($plan->archive());
    }

    /**
     * @throws PlanNotFoundExceptionInterface
     */
    public function changeProfile(ChangePlanProfile $command): PlanId
    {
        $plan = $this->getPlan($command);
        return $this->release($plan->changeProfile($command->getProfile()));
    }

    private function release(Plan $plan): PlanId
    {
        $this->planRepository->persist($plan);
        $this->domainEventBus->publish(...$plan->releaseEvents());
        return $plan->planId;
    }

    /**
     * @throws PlanNotFoundExceptionInterface
     */
    private function getPlan(PlanCommandInterface $command): Plan
    {
        return $this->planRepository->take($command->getPlanId());
    }
}
