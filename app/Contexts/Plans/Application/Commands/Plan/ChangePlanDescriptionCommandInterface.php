<?php

namespace App\Contexts\Plans\Application\Commands\Plan;

use App\Contexts\Plans\Domain\Model\Plan\Description;

interface ChangePlanDescriptionCommandInterface extends PlanCommandInterface
{
    public function getDescription(): Description;
}
