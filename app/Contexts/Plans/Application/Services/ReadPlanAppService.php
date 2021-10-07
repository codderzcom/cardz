<?php

namespace App\Contexts\Plans\Application\Services;

use App\Contexts\Plans\Infrastructure\ReadStorage\Contracts\ReadPlanStorageInterface;
use App\Shared\Contracts\ServiceResultFactoryInterface;
use App\Shared\Contracts\ServiceResultInterface;

class ReadPlanAppService
{
    public function __construct(
        private ReadPlanStorageInterface $readPlanRepository,
        private ServiceResultFactoryInterface $serviceResultFactory,
    ) {
    }

    public function getReadPlan(string $planId): ServiceResultInterface
    {
        $readPlan = $this->readPlanRepository->take($planId);
        if ($readPlan === null) {
            return $this->serviceResultFactory->notFound("ReadPlan not found for $planId");
        }
        return $this->serviceResultFactory->ok($readPlan);
    }
}
