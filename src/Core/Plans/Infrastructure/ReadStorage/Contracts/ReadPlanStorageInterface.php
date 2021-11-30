<?php

namespace Cardz\Core\Plans\Infrastructure\ReadStorage\Contracts;

use Cardz\Core\Plans\Domain\ReadModel\ReadPlan;

interface ReadPlanStorageInterface
{
    public function take(?string $planId): ?ReadPlan;
}
