<?php

namespace App\Contexts\Cards\Application\Contracts;

use App\Contexts\Cards\Domain\Model\Card\RequirementId;
use App\Contexts\Cards\Domain\Model\Shared\PlanId;
use App\Contexts\Cards\Domain\ReadModel\PlanRequirement;
use App\Contexts\Cards\Domain\ReadModel\PlanRequirementsCollection;

interface PlanRequirementReadStorageInterface
{
    public function find(RequirementId $requirementId): ?PlanRequirement;

    public function allByPlanId(PlanId $planId): PlanRequirementsCollection;
}
