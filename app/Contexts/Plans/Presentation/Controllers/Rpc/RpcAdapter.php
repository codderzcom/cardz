<?php

namespace App\Contexts\Plans\Presentation\Controllers\Rpc;

use App\Contexts\Plans\Application\Commands\Plan\AddPlan;
use App\Contexts\Plans\Application\Commands\Plan\ArchivePlan;
use App\Contexts\Plans\Application\Commands\Plan\ChangePlanDescription;
use App\Contexts\Plans\Application\Commands\Plan\LaunchPlan;
use App\Contexts\Plans\Application\Commands\Plan\StopPlan;
use App\Contexts\Plans\Application\Commands\Requirement\AddRequirement;
use App\Contexts\Plans\Application\Commands\Requirement\ChangeRequirement;
use App\Contexts\Plans\Application\Commands\Requirement\RemoveRequirement;
use App\Shared\Contracts\Commands\CommandBusInterface;
use App\Shared\Contracts\Rpc\RpcResponseInterface;
use App\Shared\Infrastructure\Rpc\RpcAdapterTrait;

/**
 * @method RpcResponseInterface addPlan(string $workspaceId, string $description)
 * @method RpcResponseInterface launchPlan(string $planId)
 * @method RpcResponseInterface stopPlan(string $planId)
 * @method RpcResponseInterface archivePlan(string $planId)
 * @method RpcResponseInterface changePlanDescription(string $planId, string $description)
 *
 * @method RpcResponseInterface addRequirement(string $planId, string $description)
 * @method RpcResponseInterface removeRequirement(string $requirementId)
 * @method RpcResponseInterface changeRequirement(string $requirementId, string $description)
 */
class RpcAdapter
{
    use RpcAdapterTrait;

    public function __construct(
        private CommandBusInterface $commandBus,
    ) {
    }

    private function addPlanMethod(string $workspaceId, string $description): string
    {
        $command = AddPlan::of($workspaceId, $description);
        $this->commandBus->dispatch($command);
        return (string) $command->getPlanId();
    }

    private function launchPlanMethod(string $planId): string
    {
        $command = LaunchPlan::of($planId);
        $this->commandBus->dispatch($command);
        return (string) $command->getPlanId();
    }

    private function stopPlanMethod(string $planId): string
    {
        $command = StopPlan::of($planId);
        $this->commandBus->dispatch($command);
        return (string) $command->getPlanId();
    }

    private function archivePlanMethod(string $planId): string
    {
        $command = ArchivePlan::of($planId);
        $this->commandBus->dispatch($command);
        return (string) $command->getPlanId();
    }

    private function changePlanDescriptionMethod(string $planId, string $description): string
    {
        $command = ChangePlanDescription::of($planId, $description);
        $this->commandBus->dispatch($command);
        return (string) $command->getPlanId();
    }

    private function addRequirementMethod(string $planId, string $description): string
    {
        $command = AddRequirement::of($planId, $description);
        $this->commandBus->dispatch($command);
        return (string) $command->getRequirementId();
    }

    private function removeRequirementMethod(string $requirementId): string
    {
        $command = RemoveRequirement::of($requirementId);
        $this->commandBus->dispatch($command);
        return (string) $command->getRequirementId();
    }

    private function changeRequirementMethod(string $requirementId, string $description): string
    {
        $command = ChangeRequirement::of($requirementId, $description);
        $this->commandBus->dispatch($command);
        return (string) $command->getRequirementId();
    }

}
