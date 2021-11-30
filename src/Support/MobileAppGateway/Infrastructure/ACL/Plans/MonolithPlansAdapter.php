<?php

namespace Cardz\Support\MobileAppGateway\Infrastructure\ACL\Plans;

use Cardz\Core\Plans\Application\Commands\Plan\AddPlan;
use Cardz\Core\Plans\Application\Commands\Plan\ArchivePlan;
use Cardz\Core\Plans\Application\Commands\Plan\ChangePlanDescription;
use Cardz\Core\Plans\Application\Commands\Plan\LaunchPlan;
use Cardz\Core\Plans\Application\Commands\Plan\StopPlan;
use Cardz\Core\Plans\Application\Commands\Requirement\AddRequirement;
use Cardz\Core\Plans\Application\Commands\Requirement\ChangeRequirement;
use Cardz\Core\Plans\Application\Commands\Requirement\RemoveRequirement;
use Cardz\Support\MobileAppGateway\Integration\Contracts\PlansContextInterface;
use Codderz\Platypus\Contracts\Commands\CommandBusInterface;

class MonolithPlansAdapter implements PlansContextInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
    ) {
    }

    public function add(string $workspaceId, string $description): string
    {
        $command = AddPlan::of($workspaceId, $description);
        $this->commandBus->dispatch($command);
        return $command->getPlanId();
    }

    public function archive(string $planId): string
    {
        $command = ArchivePlan::of($planId);
        $this->commandBus->dispatch($command);
        return $command->getPlanId();
    }

    public function changeDescription(string $planId, string $description): string
    {
        $command = ChangePlanDescription::of($planId, $description);
        $this->commandBus->dispatch($command);
        return $command->getPlanId();
    }

    public function launch(string $planId): string
    {
        $command = LaunchPlan::of($planId);
        $this->commandBus->dispatch($command);
        return $command->getPlanId();
    }

    public function stop(string $planId): string
    {
        $command = StopPlan::of($planId);
        $this->commandBus->dispatch($command);
        return $command->getPlanId();
    }

    public function addRequirement(string $planId, string $description): string
    {
        $command = AddRequirement::of($planId, $description);
        $this->commandBus->dispatch($command);
        return $command->getRequirementId();
    }

    public function changeRequirement(string $requirementId, string $description): string
    {
        $command = ChangeRequirement::of($requirementId, $description);
        $this->commandBus->dispatch($command);
        return $command->getRequirementId();
    }

    public function removeRequirement(string $requirementId): string
    {
        $command = RemoveRequirement::of($requirementId);
        $this->commandBus->dispatch($command);
        return $command->getRequirementId();
    }
}
