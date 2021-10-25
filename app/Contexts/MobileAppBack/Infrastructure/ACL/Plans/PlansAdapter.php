<?php

namespace App\Contexts\MobileAppBack\Infrastructure\ACL\Plans;

use App\Contexts\Plans\Application\Services\PlanAppService;
use App\Contexts\Plans\Application\Services\RequirementAppService;
use App\Shared\Contracts\ServiceResultFactoryInterface;
use App\Shared\Contracts\ServiceResultInterface;

class PlansAdapter
{
    //ToDo: здесь могло бы быть обращение по HTTP
    public function __construct(
        private PlanAppService $planAppService,
        private RequirementAppService $requirementAppService,
        private ServiceResultFactoryInterface $serviceResultFactory,
    ) {
    }

    public function add(string $workspaceId, string $description): ServiceResultInterface
    {
        $result = $this->planAppService->add($workspaceId, $description);
        if ($result->isNotOk()) {
            return $result;
        }
        $planId = (string) $result->getPayload()->planId;
        return $this->serviceResultFactory->ok($planId);
    }

    public function launch(string $planId): ServiceResultInterface
    {
        $result = $this->planAppService->launch($planId);
        if ($result->isNotOk()) {
            return $result;
        }
        return $this->serviceResultFactory->ok();
    }

    public function stop(string $planId): ServiceResultInterface
    {
        $result = $this->planAppService->stop($planId);
        if ($result->isNotOk()) {
            return $result;
        }
        return $this->serviceResultFactory->ok();
    }

    public function archive(string $planId): ServiceResultInterface
    {
        $result = $this->planAppService->archive($planId);
        if ($result->isNotOk()) {
            return $result;
        }
        return $this->serviceResultFactory->ok();
    }

    public function changeDescription(string $planId, string $description): ServiceResultInterface
    {
        $result = $this->planAppService->changeDescription($planId, $description);
        if ($result->isNotOk()) {
            return $result;
        }
        return $this->serviceResultFactory->ok();
    }

    public function addRequirement(string $planId, string $description): ServiceResultInterface
    {
        $result = $this->requirementAppService->add($planId, $description);
        if ($result->isNotOk()) {
            return $result;
        }
        return $this->serviceResultFactory->ok();
    }

    public function removeRequirement(string $planId, string $requirementId): ServiceResultInterface
    {
        $result = $this->requirementAppService->remove($planId, $requirementId);
        if ($result->isNotOk()) {
            return $result;
        }
        return $this->serviceResultFactory->ok();
    }

    public function changeRequirement(string $planId, string $requirementId, string $description): ServiceResultInterface
    {
        $result = $this->requirementAppService->change($planId, $requirementId, $description);
        if ($result->isNotOk()) {
            return $result;
        }
        return $this->serviceResultFactory->ok();
    }
}
