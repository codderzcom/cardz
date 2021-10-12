<?php

namespace App\Contexts\Plans\Infrastructure\Persistence\Contracts;

use App\Contexts\Plans\Domain\Model\Requirement\Requirement;
use App\Contexts\Plans\Domain\Model\Requirement\RequirementId;

interface RequirementRepositoryInterface
{
    public function persist(Requirement $requirement): void;

    public function take(RequirementId $requirementId): Requirement;

}
