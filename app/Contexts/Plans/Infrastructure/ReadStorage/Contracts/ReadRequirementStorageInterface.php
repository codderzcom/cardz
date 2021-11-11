<?php

namespace App\Contexts\Plans\Infrastructure\ReadStorage\Contracts;

use App\Contexts\Plans\Domain\ReadModel\ReadRequirement;

interface ReadRequirementStorageInterface
{
    public function take(?string $requirementId): ?ReadRequirement;
}
