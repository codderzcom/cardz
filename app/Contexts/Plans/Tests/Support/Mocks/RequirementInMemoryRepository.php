<?php

namespace App\Contexts\Plans\Tests\Support\Mocks;

use App\Contexts\Plans\Domain\Model\Requirement\Requirement;
use App\Contexts\Plans\Domain\Model\Requirement\RequirementId;
use App\Contexts\Plans\Domain\Persistence\Contracts\RequirementRepositoryInterface;

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
