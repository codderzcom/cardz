<?php

namespace App\Contexts\MobileAppBack\Application\Services\Workspace;

use App\Contexts\MobileAppBack\Application\Contracts\WorkspacePlanReadStorageInterface;
use App\Contexts\MobileAppBack\Application\Services\Workspace\Policies\AssertPlanInWorkspace;
use App\Contexts\MobileAppBack\Application\Services\Workspace\Policies\AssertWorkspaceForKeeper;
use App\Contexts\MobileAppBack\Domain\Model\Workspace\KeeperId;
use App\Contexts\MobileAppBack\Domain\Model\Workspace\PlanId;
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

    public function getWorkspacePlan(
        string $keeperId,
        string $workspaceId,
        string $planId
    ): ServiceResultInterface {
        if (!AssertWorkspaceForKeeper::of(WorkspaceId::of($workspaceId), KeeperId::of($keeperId))->assert()) {
            return $this->serviceResultFactory->violation("Workspace $workspaceId is not for keeper $keeperId");
        }
        if (!AssertPlanInWorkspace::of(PlanId::of($planId), WorkspaceId::of($workspaceId))->assert()) {
            return $this->serviceResultFactory->violation("Plan $planId is not in $workspaceId");
        }

        return $this->getWorkspacePlanResult($planId);
    }

    public function getWorkspacePlans(
        string $keeperId,
        string $workspaceId
    ): ServiceResultInterface {
        if (!AssertWorkspaceForKeeper::of(WorkspaceId::of($workspaceId), KeeperId::of($keeperId))->assert()) {
            return $this->serviceResultFactory->violation("Workspace $workspaceId is not for keeper $keeperId");
        }

        $plans = $this->workspacePlanReadStorage->allForWorkspace($workspaceId);
        return $this->serviceResultFactory->ok($plans);
    }

    public function add(
        string $keeperId,
        string $workspaceId,
        string $description
    ): ServiceResultInterface {
        if (!AssertWorkspaceForKeeper::of(WorkspaceId::of($workspaceId), KeeperId::of($keeperId))->assert()) {
            return $this->serviceResultFactory->violation("Workspace $workspaceId is not for keeper $keeperId");
        }

        $result = $this->plansAdapter->add($workspaceId, $description);
        if ($result->isNotOk()) {
            return $result;
        }
        $planId = $result->getPayload();

        return $this->getWorkspacePlanResult($planId);
    }

    public function launch(
        string $keeperId,
        string $workspaceId,
        string $planId
    ): ServiceResultInterface {
        if (!AssertWorkspaceForKeeper::of(WorkspaceId::of($workspaceId), KeeperId::of($keeperId))->assert()) {
            return $this->serviceResultFactory->violation("Workspace $workspaceId is not for keeper $keeperId");
        }
        if (!AssertPlanInWorkspace::of(PlanId::of($planId), WorkspaceId::of($workspaceId))->assert()) {
            return $this->serviceResultFactory->violation("Plan $planId is not in $workspaceId");
        }

        $result = $this->plansAdapter->launch($planId);
        if ($result->isNotOk()) {
            return $result;
        }

        return $this->getWorkspacePlanResult($planId);
    }

    public function stop(
        string $keeperId,
        string $workspaceId,
        string $planId
    ): ServiceResultInterface {
        if (!AssertWorkspaceForKeeper::of(WorkspaceId::of($workspaceId), KeeperId::of($keeperId))->assert()) {
            return $this->serviceResultFactory->violation("Workspace $workspaceId is not for keeper $keeperId");
        }
        if (!AssertPlanInWorkspace::of(PlanId::of($planId), WorkspaceId::of($workspaceId))->assert()) {
            return $this->serviceResultFactory->violation("Plan $planId is not in $workspaceId");
        }

        $result = $this->plansAdapter->stop($planId);
        if ($result->isNotOk()) {
            return $result;
        }

        return $this->getWorkspacePlanResult($planId);
    }

    public function archive(
        string $keeperId,
        string $workspaceId,
        string $planId
    ): ServiceResultInterface {
        if (!AssertWorkspaceForKeeper::of(WorkspaceId::of($workspaceId), KeeperId::of($keeperId))->assert()) {
            return $this->serviceResultFactory->violation("Workspace $workspaceId is not for keeper $keeperId");
        }
        if (!AssertPlanInWorkspace::of(PlanId::of($planId), WorkspaceId::of($workspaceId))->assert()) {
            return $this->serviceResultFactory->violation("Plan $planId is not in $workspaceId");
        }

        $result = $this->plansAdapter->archive($planId);
        if ($result->isNotOk()) {
            return $result;
        }

        return $this->getWorkspacePlanResult($planId);
    }

    public function changeDescription(
        string $keeperId,
        string $workspaceId,
        string $planId,
        string $description
    ): ServiceResultInterface {
        if (!AssertWorkspaceForKeeper::of(WorkspaceId::of($workspaceId), KeeperId::of($keeperId))->assert()) {
            return $this->serviceResultFactory->violation("Workspace $workspaceId is not for keeper $keeperId");
        }
        if (!AssertPlanInWorkspace::of(PlanId::of($planId), WorkspaceId::of($workspaceId))->assert()) {
            return $this->serviceResultFactory->violation("Plan $planId is not in $workspaceId");
        }

        $result = $this->plansAdapter->changeDescription($planId, $description);
        if ($result->isNotOk()) {
            return $result;
        }

        return $this->getWorkspacePlanResult($planId);
    }

    public function addRequirement(
        string $keeperId,
        string $workspaceId,
        string $planId,
        string $description
    ): ServiceResultInterface {
        if (!AssertWorkspaceForKeeper::of(WorkspaceId::of($workspaceId), KeeperId::of($keeperId))->assert()) {
            return $this->serviceResultFactory->violation("Workspace $workspaceId is not for keeper $keeperId");
        }
        if (!AssertPlanInWorkspace::of(PlanId::of($planId), WorkspaceId::of($workspaceId))->assert()) {
            return $this->serviceResultFactory->violation("Plan $planId is not in $workspaceId");
        }

        $result = $this->plansAdapter->addRequirement($planId, $description);
        if ($result->isNotOk()) {
            return $result;
        }

        return $this->getWorkspacePlanResult($planId);
    }

    public function removeRequirement(
        string $keeperId,
        string $workspaceId,
        string $planId,
        string $requirementId
    ): ServiceResultInterface {
        if (!AssertWorkspaceForKeeper::of(WorkspaceId::of($workspaceId), KeeperId::of($keeperId))->assert()) {
            return $this->serviceResultFactory->violation("Workspace $workspaceId is not for keeper $keeperId");
        }
        if (!AssertPlanInWorkspace::of(PlanId::of($planId), WorkspaceId::of($workspaceId))->assert()) {
            return $this->serviceResultFactory->violation("Plan $planId is not in $workspaceId");
        }

        $result = $this->plansAdapter->removeRequirement($planId, $requirementId);
        if ($result->isNotOk()) {
            return $result;
        }

        return $this->getWorkspacePlanResult($planId);
    }

    public function changeRequirement(
        string $keeperId,
        string $workspaceId,
        string $planId,
        string $requirementId,
        string $description
    ): ServiceResultInterface {
        if (!AssertWorkspaceForKeeper::of(WorkspaceId::of($workspaceId), KeeperId::of($keeperId))->assert()) {
            return $this->serviceResultFactory->violation("Workspace $workspaceId is not for keeper $keeperId");
        }
        if (!AssertPlanInWorkspace::of(PlanId::of($planId), WorkspaceId::of($workspaceId))->assert()) {
            return $this->serviceResultFactory->violation("Plan $planId is not in $workspaceId");
        }

        $result = $this->plansAdapter->changeRequirement($planId, $requirementId, $description);
        if ($result->isNotOk()) {
            return $result;
        }

        return $this->getWorkspacePlanResult($planId);
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
