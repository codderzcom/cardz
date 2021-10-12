<?php

namespace App\Contexts\Plans\Application\Commands\Requirement;

use App\Contexts\Plans\Domain\Model\Plan\PlanId;

interface AddRequirementCommandInterface extends RequirementCommandInterface
{
    public function getPlanId(): PlanId;

    public function getDescription(): string;
}
