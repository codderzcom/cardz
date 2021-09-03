<?php

namespace App\Contexts\Cards\Infrastructure\ACL\Plans;

use App\Contexts\Plans\Application\Services\RequirementsCalculationAppService;
use App\Contexts\Shared\Contracts\ServiceResultInterface;

class PlansAdapter
{
    //ToDo: сцепление с соседним контекстом. При переходе на микросервисы, можно например, API юзать
    public function __construct(
        private RequirementsCalculationAppService $requirementsCalculationAppService
    ) {
    }

    public function unachievedRequirements(string $planId, string ...$achievedRequirementIds): ServiceResultInterface
    {
        $result = $this->requirementsCalculationAppService->restOfRequirements(
            $planId,
            ...$achievedRequirementIds
        );
        //ToDo: маппинг ответа
        return $result;
    }
}
