<?php

namespace App\Contexts\Cards\Infrastructure\ReadStorage\Contracts;

use App\Contexts\Cards\Domain\ReadModel\ReadPlan;

interface ReadPlanStorageInterface
{
    public function take(?string $planId): ?ReadPlan;
}
