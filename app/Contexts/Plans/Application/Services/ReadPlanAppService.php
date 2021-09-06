<?php

namespace App\Contexts\Plans\Application\Services;

use App\Contexts\Plans\Application\Contracts\ReadPlanRepositoryInterface;
use App\Contexts\Shared\Contracts\ServiceResultFactoryInterface;
use App\Contexts\Shared\Contracts\ServiceResultInterface;

class ReadPlanAppService
{
    public function __construct(
        private ReadPlanRepositoryInterface $readPlanRepository,
        private ServiceResultFactoryInterface $serviceResultFactory,
    ) {
    }

    public function getReadPlan(string $planId): ServiceResultInterface
    {
        $readPlan = $this->readPlanRepository->take($planId);
        if ($readPlan === null) {
            return $this->serviceResultFactory->notFound("ReadPlan not found for $planId");
        }
        $this->serviceResultFactory->ok($readPlan);
    }
}
