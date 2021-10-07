<?php

namespace App\Contexts\Plans\Application\Commands\Requirement;

use App\Contexts\Plans\Domain\Model\Plan\PlanId;
use App\Contexts\Plans\Domain\Model\Requirement\RequirementId;
use App\Shared\Contracts\Commands\CommandInterface;

interface AddRequirementCommandInterface extends CommandInterface
{
    public function getPlanId(): PlanId;

    public function getRequirementId(): RequirementId;

    public function getDescription(): string;
}
