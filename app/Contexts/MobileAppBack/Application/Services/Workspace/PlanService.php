<?php

namespace App\Contexts\MobileAppBack\Application\Services\Workspace;

use App\Contexts\MobileAppBack\Application\Contracts\WorkspacePlanReadStorageInterface;
use App\Contexts\MobileAppBack\Application\Services\Workspace\Policies\AssertPlanInWorkspace;
use App\Contexts\MobileAppBack\Application\Services\Workspace\Policies\AssertWorkspaceForKeeper;
use App\Contexts\MobileAppBack\Domain\Model\Collaboration\KeeperId;
use App\Contexts\MobileAppBack\Domain\Model\Workspace\PlanId;
use App\Contexts\MobileAppBack\Domain\Model\Workspace\WorkspaceId;
use App\Contexts\MobileAppBack\Infrastructure\ACL\Plans\PlansAdapter;
use App\Contexts\Shared\Contracts\PolicyEngineInterface;
use App\Contexts\Shared\Contracts\ServiceResultFactoryInterface;
use App\Contexts\Shared\Contracts\ServiceResultInterface;

class PlanService
{
    public function __construct(
        private PlansAdapter $plansAdapter,
        private WorkspacePlanReadStorageInterface $workspacePlanReadStorage,
        private PolicyEngineInterface $policyEngine,
        private ServiceResultFactoryInterface $serviceResultFactory,
    ) {
    }

    public function getWorkspacePlan(
        string $keeperId,
        string $workspaceId,
        string $planId
    ): ServiceResultInterface {
        return $this->policyEngine->passTrough(
            function () use ($planId) {
                return $this->getWorkspacePlanResult($planId);
            },

            AssertWorkspaceForKeeper::of(WorkspaceId::of($workspaceId), KeeperId::of($keeperId)),
            AssertPlanInWorkspace::of(PlanId::of($planId), WorkspaceId::of($workspaceId)),
        );
    }

    public function getWorkspacePlans(
        string $keeperId,
        string $workspaceId
    ): ServiceResultInterface {
        return $this->policyEngine->passTrough(
            function () use ($workspaceId) {
                $plans = $this->workspacePlanReadStorage->allForWorkspace($workspaceId);
                return $this->serviceResultFactory->ok($plans);
            },

            AssertWorkspaceForKeeper::of(WorkspaceId::of($workspaceId), KeeperId::of($keeperId)),
        );
    }

    public function add(
        string $keeperId,
        string $workspaceId,
        string $description
    ): ServiceResultInterface {
        return $this->policyEngine->passTrough(
            function () use ($workspaceId, $description) {
                $result = $this->plansAdapter->add($workspaceId, $description);
                if ($result->isNotOk()) {
                    return $result;
                }
                $planId = $result->getPayload();
                return $this->getWorkspacePlanResult($planId);
            },

            AssertWorkspaceForKeeper::of(WorkspaceId::of($workspaceId), KeeperId::of($keeperId)),
        );
    }

    public function launch(
        string $keeperId,
        string $workspaceId,
        string $planId
    ): ServiceResultInterface {
        return $this->policyEngine->passTrough(
            function () use ($planId) {
                $result = $this->plansAdapter->launch($planId);
                if ($result->isNotOk()) {
                    return $result;
                }
                return $this->getWorkspacePlanResult($planId);
            },

            AssertWorkspaceForKeeper::of(WorkspaceId::of($workspaceId), KeeperId::of($keeperId)),
            AssertPlanInWorkspace::of(PlanId::of($planId), WorkspaceId::of($workspaceId)),
        );
    }

    public function stop(
        string $keeperId,
        string $workspaceId,
        string $planId
    ): ServiceResultInterface {
        return $this->policyEngine->passTrough(
            function () use ($planId) {
                $result = $this->plansAdapter->stop($planId);
                if ($result->isNotOk()) {
                    return $result;
                }
                return $this->getWorkspacePlanResult($planId);
            },

            AssertWorkspaceForKeeper::of(WorkspaceId::of($workspaceId), KeeperId::of($keeperId)),
            AssertPlanInWorkspace::of(PlanId::of($planId), WorkspaceId::of($workspaceId)),
        );
    }

    public function archive(
        string $keeperId,
        string $workspaceId,
        string $planId
    ): ServiceResultInterface {
        return $this->policyEngine->passTrough(
            function () use ($planId) {
                $result = $this->plansAdapter->archive($planId);
                if ($result->isNotOk()) {
                    return $result;
                }
                return $this->getWorkspacePlanResult($planId);
            },

            AssertWorkspaceForKeeper::of(WorkspaceId::of($workspaceId), KeeperId::of($keeperId)),
            AssertPlanInWorkspace::of(PlanId::of($planId), WorkspaceId::of($workspaceId)),
        );
    }

    public function changeDescription(
        string $keeperId,
        string $workspaceId,
        string $planId,
        string $description
    ): ServiceResultInterface {
        return $this->policyEngine->passTrough(
            function () use ($planId, $description) {
                $result = $this->plansAdapter->changeDescription($planId, $description);
                if ($result->isNotOk()) {
                    return $result;
                }
                return $this->getWorkspacePlanResult($planId);
            },

            AssertWorkspaceForKeeper::of(WorkspaceId::of($workspaceId), KeeperId::of($keeperId)),
            AssertPlanInWorkspace::of(PlanId::of($planId), WorkspaceId::of($workspaceId)),
        );
    }

    public function addRequirement(
        string $keeperId,
        string $workspaceId,
        string $planId,
        string $description
    ): ServiceResultInterface {
        return $this->policyEngine->passTrough(
            function () use ($planId, $description) {
                $result = $this->plansAdapter->addRequirement($planId, $description);
                if ($result->isNotOk()) {
                    return $result;
                }
                return $this->getWorkspacePlanResult($planId);
            },

            AssertWorkspaceForKeeper::of(WorkspaceId::of($workspaceId), KeeperId::of($keeperId)),
            AssertPlanInWorkspace::of(PlanId::of($planId), WorkspaceId::of($workspaceId)),
        );
    }

    public function removeRequirement(
        string $keeperId,
        string $workspaceId,
        string $planId,
        string $requirementId
    ): ServiceResultInterface {
        return $this->policyEngine->passTrough(
            function () use ($planId, $requirementId) {
                $result = $this->plansAdapter->removeRequirement($planId, $requirementId);
                if ($result->isNotOk()) {
                    return $result;
                }
                return $this->getWorkspacePlanResult($planId);
            },

            AssertWorkspaceForKeeper::of(WorkspaceId::of($workspaceId), KeeperId::of($keeperId)),
            AssertPlanInWorkspace::of(PlanId::of($planId), WorkspaceId::of($workspaceId)),
        );
    }

    public function changeRequirement(
        string $keeperId,
        string $workspaceId,
        string $planId,
        string $requirementId,
        string $description
    ): ServiceResultInterface {
        return $this->policyEngine->passTrough(
            function () use ($planId, $requirementId, $description) {
                $result = $this->plansAdapter->changeRequirement($planId, $requirementId, $description);
                if ($result->isNotOk()) {
                    return $result;
                }
                return $this->getWorkspacePlanResult($planId);
            },

            AssertWorkspaceForKeeper::of(WorkspaceId::of($workspaceId), KeeperId::of($keeperId)),
            AssertPlanInWorkspace::of(PlanId::of($planId), WorkspaceId::of($workspaceId)),
        );
    }

    private function getWorkspacePlanResult(string $planId): ServiceResultInterface
    {
        $plan = $this->workspacePlanReadStorage->find($planId);
        if ($plan === null) {
            return $this->serviceResultFactory->notFound("Plan $planId not found");
        }

        return $this->serviceResultFactory->ok($plan);
    }
}
