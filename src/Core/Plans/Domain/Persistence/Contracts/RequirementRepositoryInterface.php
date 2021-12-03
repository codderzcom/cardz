<?php

namespace Cardz\Core\Plans\Domain\Persistence\Contracts;

use Cardz\Core\Plans\Domain\Exceptions\RequirementNotFoundExceptionInterface;
use Cardz\Core\Plans\Domain\Model\Requirement\Requirement;
use Cardz\Core\Plans\Domain\Model\Requirement\RequirementId;

interface RequirementRepositoryInterface
{
    public function persist(Requirement $requirement): void;

    /**
     * @throws RequirementNotFoundExceptionInterface
     */
    public function take(RequirementId $requirementId): Requirement;

}
