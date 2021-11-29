<?php

namespace App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace;

use App\Contexts\Authorization\Domain\Permissions\AuthorizationPermission;
use App\Contexts\MobileAppBack\Application\Services\AuthorizationServiceInterface;
use App\Contexts\MobileAppBack\Application\Services\Workspace\PlanAppService;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\BaseController;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Commands\{Plan\AddPlanRequest,
    Plan\AddPlanRequirementRequest,
    Plan\ChangePlanDescriptionRequest,
    Plan\ChangePlanRequirementDescriptionRequest,
    Plan\PlanCommandRequest,
    Plan\RemovePlanRequirementRequest
};
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Queries\GetPlanRequest;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Queries\GetWorkspaceRequest;
use App\Shared\Contracts\GeneralIdInterface;
use Illuminate\Http\JsonResponse;

class PlanController extends BaseController
{
    public function __construct(
        private PlanAppService $planService,
        private AuthorizationServiceInterface $authorizationService,
    ) {
    }

    public function getWorkspaceBusinessPlans(GetWorkspaceRequest $request): JsonResponse
    {
        $this->authorizationService->authorize(
            AuthorizationPermission::PLAN_VIEW(),
            $request->collaboratorId,
            $request->workspaceId,
        );

        return $this->response($this->planService->getWorkspaceBusinessPlans($request->workspaceId));
    }

    public function getPlan(GetPlanRequest $request): JsonResponse
    {
        $this->authorizationService->authorize(
            AuthorizationPermission::PLAN_VIEW(),
            $request->collaboratorId,
            $request->workspaceId,
        );

        return $this->response($this->planService->getBusinessPlan($request->planId));
    }

    public function add(AddPlanRequest $request): JsonResponse
    {
        $this->authorizationService->authorize(
            AuthorizationPermission::PLAN_ADD(),
            $request->collaboratorId,
            $request->workspaceId,
        );

        return $this->response($this->planService->add($request->workspaceId, $request->description));
    }

    public function launch(PlanCommandRequest $request): JsonResponse
    {
        $this->authorizePlanChange($request->collaboratorId, $request->planId);
        return $this->response($this->planService->launch($request->planId));
    }

    public function stop(PlanCommandRequest $request): JsonResponse
    {
        $this->authorizePlanChange($request->collaboratorId, $request->planId);
        return $this->response($this->planService->stop($request->planId));
    }

    public function archive(PlanCommandRequest $request): JsonResponse
    {
        $this->authorizePlanChange($request->collaboratorId, $request->planId);
        return $this->response($this->planService->archive($request->planId));
    }

    public function changeDescription(ChangePlanDescriptionRequest $request): JsonResponse
    {
        $this->authorizePlanChange($request->collaboratorId, $request->planId);
        return $this->response($this->planService->changeDescription($request->planId, $request->description));
    }

    public function addRequirement(AddPlanRequirementRequest $request): JsonResponse
    {
        $this->authorizePlanChange($request->collaboratorId, $request->planId);
        return $this->response($this->planService->addRequirement($request->planId, $request->description));
    }

    public function removeRequirement(RemovePlanRequirementRequest $request): JsonResponse
    {
        $this->authorizePlanChange($request->collaboratorId, $request->planId);
        return $this->response($this->planService->removeRequirement($request->planId, $request->requirementId));
    }

    public function changeRequirement(ChangePlanRequirementDescriptionRequest $request): JsonResponse
    {
        $this->authorizePlanChange($request->collaboratorId, $request->planId);
        return $this->response($this->planService->changeRequirement(
            $request->planId,
            $request->requirementId,
            $request->description,
        ));
    }

    private function authorizePlanChange(GeneralIdInterface $collaboratorId, GeneralIdInterface $planId): void
    {
        $this->authorizationService->authorize(
            AuthorizationPermission::PLAN_CHANGE(),
            $collaboratorId,
            $planId,
        );
    }

}
