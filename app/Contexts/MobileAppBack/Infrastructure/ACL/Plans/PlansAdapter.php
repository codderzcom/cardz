<?php

namespace App\Contexts\MobileAppBack\Infrastructure\ACL\Plans;

use App\Contexts\Plans\Application\Services\PlanAppService;
use App\Contexts\Shared\Contracts\ServiceResultFactoryInterface;
use App\Contexts\Shared\Contracts\ServiceResultInterface;

class PlansAdapter
{
    //ToDo: здесь могло бы быть обращение по HTTP
    public function __construct(
        private PlanAppService $planAppService,
        private ServiceResultFactoryInterface $serviceResultFactory,
    ) {
    }

    public function add(string $workspaceId, string $description): ServiceResultInterface
    {
        $result = $this->planAppService->add($workspaceId, $description);
        if ($result->isNotOk()){
            return $result;
        }
        $planId = (string) $result->getPayload()->planId;
        return $this->serviceResultFactory->ok($planId);
    }

    public function launch(string $planId): ServiceResultInterface
    {
        $result = $this->planAppService->launch($planId);
        if ($result->isNotOk()){
            return $result;
        }
        return $this->serviceResultFactory->ok();
    }

    public function stop(string $planId): ServiceResultInterface
    {
        $result = $this->planAppService->stop($planId);
        if ($result->isNotOk()){
            return $result;
        }
        return $this->serviceResultFactory->ok();
    }

    public function archive(string $planId): ServiceResultInterface
    {
        $result = $this->planAppService->archive($planId);
        if ($result->isNotOk()){
            return $result;
        }
        return $this->serviceResultFactory->ok();
    }

    public function changeDescription(string $planId, string $description): ServiceResultInterface
    {
        $result = $this->planAppService->changeDescription($planId, $description);
        if ($result->isNotOk()){
            return $result;
        }
        return $this->serviceResultFactory->ok();
    }

    public function addRequirement(string $planId, string $description): ServiceResultInterface
    {
        $result = $this->planAppService->addRequirement($planId, $description);
        if ($result->isNotOk()){
            return $result;
        }
        return $this->serviceResultFactory->ok();
    }

    public function removeRequirement(string $planId, string $description): ServiceResultInterface
    {
        $result = $this->planAppService->removeRequirement($planId, $description);
        if ($result->isNotOk()){
            return $result;
        }
        return $this->serviceResultFactory->ok();
    }

    public function changeRequirements(string $planId, string ...$descriptions): ServiceResultInterface
    {
        $result = $this->planAppService->changeRequirements($planId, ...$descriptions);
        if ($result->isNotOk()){
            return $result;
        }
        return $this->serviceResultFactory->ok();
    }
}
