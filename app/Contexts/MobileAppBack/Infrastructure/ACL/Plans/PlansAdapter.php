<?php

namespace App\Contexts\MobileAppBack\Infrastructure\ACL\Plans;

use App\Contexts\MobileAppBack\Integration\Contracts\PlansContextInterface;
use App\Contexts\Plans\Application\Commands\Plan\AddPlan;
use App\Shared\Contracts\Commands\CommandBusInterface;

class PlansAdapter implements PlansContextInterface
{
    //ToDo: здесь могло бы быть обращение по HTTP
    public function __construct(
        private CommandBusInterface $commandBus
    ) {
    }

    public function add(string $name)
    {
        $command = AddPlan::of();
    }

    public function launch(string $planId)
    {
    }

    public function stop(string $planId)
    {
    }

    public function archive(string $planId)
    {
    }

    public function changeDescription(string $planId, string $description)
    {
    }

    public function addRequirement(string $planId, string $description)
    {
    }

    public function removeRequirement(string $planId, string $requirementId)
    {
    }

    public function changeRequirement(string $planId, string $requirementId, string $description)
    {
    }
}
