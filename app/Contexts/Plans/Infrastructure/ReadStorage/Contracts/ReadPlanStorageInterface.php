<?php

namespace App\Contexts\Plans\Infrastructure\ReadStorage\Contracts;

use App\Contexts\Plans\Domain\ReadModel\ReadPlan;

interface ReadPlanStorageInterface
{
    public function take(?string $planId): ?ReadPlan;
}
