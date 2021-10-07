<?php

namespace App\Contexts\Plans\Application\Commands\Plan;

use App\Contexts\Plans\Domain\Model\Plan\Description;
use App\Contexts\Plans\Domain\Model\Plan\PlanId;
use App\Shared\Contracts\Commands\CommandInterface;

interface ChangePlanDescriptionCommandInterface extends CommandInterface
{
    public function getPlanId(): PlanId;

    public function getDescription(): Description;
}
