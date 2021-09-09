<?php

namespace App\Contexts\MobileAppBack\Application\Services\Workspace;

use App\Contexts\MobileAppBack\Application\Contracts\WorkspacePlanReadStorageInterface;
use App\Contexts\MobileAppBack\Application\Services\Workspace\Policies\AssertPlanInWorkspace;
use App\Contexts\MobileAppBack\Domain\Model\Plan\PlanId;
use App\Contexts\MobileAppBack\Domain\Model\Workspace\WorkspaceId;
use App\Contexts\MobileAppBack\Infrastructure\ACL\Plans\PlansAdapter;
use App\Contexts\Shared\Contracts\ServiceResultFactoryInterface;
use App\Contexts\Shared\Contracts\ServiceResultInterface;

class PlanService
{
    public function __construct(
        private PlansAdapter $plansAdapter,
        private WorkspacePlanReadStorageInterface $workspacePlanReadStorage,
        private ServiceResultFactoryInterface $serviceResultFactory,
    ) {
    }

    public function getWorkspacePlan(string $workspaceId, string $planId): ServiceResultInterface
    {
        if (!AssertPlanInWorkspace::of(PlanId::of($planId), WorkspaceId::of($workspaceId))->assert()) {
            return $this->serviceResultFactory->violation("Plan $planId is not in $workspaceId");
        }
        $plan = $this->workspacePlanReadStorage->find($planId);
        return $this->serviceResultFactory->ok($plan);
    }

    public function getWorkspacePlans(string $workspaceId): ServiceResultInterface
    {
        $plans = $this->workspacePlanReadStorage->allForWorkspace($workspaceId);
        return $this->serviceResultFactory->ok($plans);
    }

    public function add(string $workspaceId, string $description): ServiceResultInterface
    {
        $result = $this->plansAdapter->add($workspaceId, $description);
        if ($result->isNotOk()) {
            return $result;
        }
        $planId = $result->getPayload();

        $plan = $this->workspacePlanReadStorage->find($planId);
        if ($plan === null) {
            return $this->serviceResultFactory->notFound("Plan $planId could not be found after creation");
        }

        return $this->serviceResultFactory->ok($plan);
    }

    public function launch(string $planId): ServiceResultInterface
    {
        $result = $this->plansAdapter->launch($planId);
        if ($result->isNotOk()) {
            return $result;
        }

        $plan = $this->workspacePlanReadStorage->find($planId);
        if ($plan === null) {
            return $this->serviceResultFactory->notFound("Plan $planId not found");
        }

        return $this->serviceResultFactory->ok($plan);
    }

    public function stop(string $planId): ServiceResultInterface
    {
        $result = $this->plansAdapter->stop($planId);
        if ($result->isNotOk()) {
            return $result;
        }

        $plan = $this->workspacePlanReadStorage->find($planId);
        if ($plan === null) {
            return $this->serviceResultFactory->notFound("Plan $planId not found");
        }

        return $this->serviceResultFactory->ok($plan);
    }

    public function archive(string $planId): ServiceResultInterface
    {
        $result = $this->plansAdapter->archive($planId);
        if ($result->isNotOk()) {
            return $result;
        }

        $plan = $this->workspacePlanReadStorage->find($planId);
        if ($plan === null) {
            return $this->serviceResultFactory->notFound("Plan $planId not found");
        }

        return $this->serviceResultFactory->ok($plan);
    }

    public function changeDescription(string $planId, string $description): ServiceResultInterface
    {
        $result = $this->plansAdapter->changeDescription($planId, $description);
        if ($result->isNotOk()) {
            return $result;
        }

        $plan = $this->workspacePlanReadStorage->find($planId);
        if ($plan === null) {
            return $this->serviceResultFactory->notFound("Plan $planId not found");
        }

        return $this->serviceResultFactory->ok($plan);
    }

    public function addRequirement(string $planId, string $description): ServiceResultInterface
    {
        $result = $this->plansAdapter->addRequirement($planId, $description);
        if ($result->isNotOk()) {
            return $result;
        }

        $plan = $this->workspacePlanReadStorage->find($planId);
        if ($plan === null) {
            return $this->serviceResultFactory->notFound("Plan $planId not found");
        }

        return $this->serviceResultFactory->ok($plan);
    }

    public function removeRequirement(string $planId, string $description): ServiceResultInterface
    {
        $result = $this->plansAdapter->removeRequirement($planId, $description);
        if ($result->isNotOk()) {
            return $result;
        }

        $plan = $this->workspacePlanReadStorage->find($planId);
        if ($plan === null) {
            return $this->serviceResultFactory->notFound("Plan $planId not found");
        }

        return $this->serviceResultFactory->ok($plan);
    }

    public function changeRequirements(string $planId, string ...$descriptions): ServiceResultInterface
    {
        $result = $this->plansAdapter->changeRequirements($planId, ...$descriptions);
        if ($result->isNotOk()) {
            return $result;
        }

        $plan = $this->workspacePlanReadStorage->find($planId);
        if ($plan === null) {
            return $this->serviceResultFactory->notFound("Plan $planId not found");
        }

        return $this->serviceResultFactory->ok($plan);
    }
}
