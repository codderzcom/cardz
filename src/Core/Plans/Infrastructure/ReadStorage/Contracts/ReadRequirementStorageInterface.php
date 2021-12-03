<?php

namespace Cardz\Core\Plans\Infrastructure\ReadStorage\Contracts;

use Cardz\Core\Plans\Domain\ReadModel\ReadRequirement;

interface ReadRequirementStorageInterface
{
    public function take(?string $requirementId): ?ReadRequirement;
}
