<?php

namespace App\Contexts\Plans\Application\Contracts;

use App\Contexts\Plans\Domain\Model\Requirement\Requirement;
use App\Contexts\Plans\Domain\Model\Requirement\RequirementId;

interface RequirementRepositoryInterface
{
    public function persist(Requirement $requirement): void;

    public function take(RequirementId $requirementId): ?Requirement;

    public function remove(Requirement $requirement): void;
}
