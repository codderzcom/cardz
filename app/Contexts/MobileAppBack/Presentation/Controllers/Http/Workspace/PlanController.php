<?php

namespace App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace;

use App\Contexts\MobileAppBack\Application\Services\AuthorizationServiceInterface;
use App\Contexts\MobileAppBack\Application\Services\Workspace\PlanAppService;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\BaseController;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Commands\{Plan\AddPlanRequest,
    Plan\AddPlanRequirementRequest,
    Plan\ChangePlanDescriptionRequest,
    Plan\ChangePlanRequirementDescriptionRequest,
    Plan\PlanCommandRequest,
    Plan\RemovePlanRequirementRequest};
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Queries\GetPlanRequest;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Queries\GetWorkspaceRequest;
use Illuminate\Http\JsonResponse;

class PlanController extends BaseController
{
    public function __construct(
        private PlanAppService $planService,
        private AuthorizationServiceInterface $authorizationService,
    ) {
    }

    public function getPlans(GetWorkspaceRequest $request): JsonResponse
    {
        return $this->response($this->planService->getWorkspacePlans(
            $request->collaboratorId,
            $request->workspaceId,
        ));
    }

    public function getPlan(GetPlanRequest $request): JsonResponse
    {
        return $this->response($this->planService->getWorkspacePlan(
            $request->collaboratorId,
            $request->workspaceId,
            $request->planId,
        ));
    }

    public function add(AddPlanRequest $request): JsonResponse
    {
        return $this->response($this->planService->add(
            $request->collaboratorId,
            $request->workspaceId,
            $request->description,
        ));
    }

    public function launch(PlanCommandRequest $request): JsonResponse
    {
        return $this->response($this->planService->launch(
            $request->collaboratorId,
            $request->workspaceId,
            $request->planId,
        ));
    }

    public function stop(PlanCommandRequest $request): JsonResponse
    {
        $this->response($this->planService->stop(
            $request->collaboratorId,
            $request->workspaceId,
            $request->planId,
        ));
    }

    public function archive(PlanCommandRequest $request): JsonResponse
    {
        return $this->response($this->planService->archive(
            $request->collaboratorId,
            $request->workspaceId,
            $request->planId,
        ));
    }

    public function changeDescription(ChangePlanDescriptionRequest $request): JsonResponse
    {
        return $this->response($this->planService->changeDescription(
            $request->collaboratorId,
            $request->workspaceId,
            $request->planId,
            $request->description,
        ));
    }

    public function addRequirement(AddPlanRequirementRequest $request): JsonResponse
    {
        return $this->response($this->planService->addRequirement(
            $request->collaboratorId,
            $request->workspaceId,
            $request->planId,
            $request->description,
        ));
    }

    public function removeRequirement(RemovePlanRequirementRequest $request): JsonResponse
    {
        return $this->response($this->planService->removeRequirement(
            $request->collaboratorId,
            $request->workspaceId,
            $request->planId,
            $request->requirementId,
        ));
    }

    public function changeRequirement(ChangePlanRequirementDescriptionRequest $request): JsonResponse
    {
        return $this->response($this->planService->changeRequirement(
            $request->collaboratorId,
            $request->workspaceId,
            $request->planId,
            $request->requirementId,
            $request->description,
        ));
    }

}
