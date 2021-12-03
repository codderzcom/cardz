<?php

namespace Cardz\Core\Plans\Tests\Support\Mocks;

use Cardz\Core\Plans\Domain\Model\Requirement\Requirement;
use Cardz\Core\Plans\Domain\Model\Requirement\RequirementId;
use Cardz\Core\Plans\Domain\Persistence\Contracts\RequirementRepositoryInterface;

class RequirementInMemoryRepository implements RequirementRepositoryInterface
{
    protected static array $storage = [];

    public function persist(Requirement $requirement): void
    {
        static::$storage[(string) $requirement->requirementId] = $requirement;
    }

    public function take(RequirementId $requirementId): Requirement
    {
        $requirement = static::$storage[(string) $requirementId];
        return $requirement;
    }
}
