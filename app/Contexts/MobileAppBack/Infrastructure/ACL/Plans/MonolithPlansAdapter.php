<?php

namespace App\Contexts\MobileAppBack\Infrastructure\ACL\Plans;

use App\Contexts\MobileAppBack\Integration\Contracts\PlansContextInterface;
use App\Contexts\Plans\Application\Commands\Plan\AddPlan;
use App\Contexts\Plans\Application\Commands\Plan\ArchivePlan;
use App\Contexts\Plans\Application\Commands\Plan\ChangePlanDescription;
use App\Contexts\Plans\Application\Commands\Plan\LaunchPlan;
use App\Contexts\Plans\Application\Commands\Plan\StopPlan;
use App\Contexts\Plans\Application\Commands\Requirement\AddRequirement;
use App\Contexts\Plans\Application\Commands\Requirement\ChangeRequirement;
use App\Contexts\Plans\Application\Commands\Requirement\RemoveRequirement;
use App\Shared\Contracts\Commands\CommandBusInterface;

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
