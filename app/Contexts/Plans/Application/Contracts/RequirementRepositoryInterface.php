<?php

namespace App\Contexts\Plans\Application\Contracts;

use App\Contexts\Plans\Domain\Model\Plan\PlanId;
use App\Contexts\Plans\Domain\Model\Requirement\Requirement;
use App\Contexts\Plans\Domain\Model\Requirement\RequirementCollection;
use App\Contexts\Plans\Domain\Model\Requirement\RequirementId;
use App\Contexts\Plans\Domain\Model\Requirement\RequirementIdCollection;

interface RequirementRepositoryInterface
{
    public function persist(?Requirement $requirement): void;

    public function take(RequirementId $requirementId): ?Requirement;

    public function takeByRequirementIds(RequirementIdCollection $requirementIdCollection): RequirementCollection;

    public function takeByPlanId(PlanId $planId): RequirementCollection;
}
