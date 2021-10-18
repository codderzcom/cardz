<?php

namespace App\Contexts\Plans\Domain\Persistence\Contracts;

use App\Contexts\Plans\Domain\Exceptions\RequirementNotFoundExceptionInterface;
use App\Contexts\Plans\Domain\Model\Requirement\Requirement;
use App\Contexts\Plans\Domain\Model\Requirement\RequirementId;

interface RequirementRepositoryInterface
{
    public function persist(Requirement $requirement): void;

    /**
     * @throws RequirementNotFoundExceptionInterface
     */
    public function take(RequirementId $requirementId): Requirement;

}
