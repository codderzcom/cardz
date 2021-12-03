<?php

namespace Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace;

use Cardz\Support\MobileAppGateway\Application\Services\Workspace\PlanAppService;
use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\BaseController;
use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Commands\{Plan\AddPlanRequest,
    Plan\AddPlanRequirementRequest,
    Plan\ChangePlanDescriptionRequest,
    Plan\ChangePlanRequirementDescriptionRequest,
    Plan\PlanCommandRequest,
    Plan\RemovePlanRequirementRequest
};
use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Queries\GetPlanRequest;
use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Queries\GetWorkspaceRequest;
use Illuminate\Http\JsonResponse;

class PlanController extends BaseController
{
    public function __construct(
        private PlanAppService $planService,
    ) {
    }

    public function getWorkspaceBusinessPlans(GetWorkspaceRequest $request): JsonResponse
    {
        return $this->response($this->planService->getWorkspaceBusinessPlans($request->workspaceId));
    }

    public function getPlan(GetPlanRequest $request): JsonResponse
    {
        return $this->response($this->planService->getBusinessPlan($request->planId));
    }

    public function add(AddPlanRequest $request): JsonResponse
    {
        return $this->response($this->planService->add($request->workspaceId, $request->description));
    }

    public function launch(PlanCommandRequest $request): JsonResponse
    {
        return $this->response($this->planService->launch($request->planId));
    }

    public function stop(PlanCommandRequest $request): JsonResponse
    {
        return $this->response($this->planService->stop($request->planId));
    }

    public function archive(PlanCommandRequest $request): JsonResponse
    {
        return $this->response($this->planService->archive($request->planId));
    }

    public function changeDescription(ChangePlanDescriptionRequest $request): JsonResponse
    {
        return $this->response($this->planService->changeDescription($request->planId, $request->description));
    }

    public function addRequirement(AddPlanRequirementRequest $request): JsonResponse
    {
        return $this->response($this->planService->addRequirement($request->planId, $request->description));
    }

    public function removeRequirement(RemovePlanRequirementRequest $request): JsonResponse
    {
        return $this->response($this->planService->removeRequirement($request->planId, $request->requirementId));
    }

    public function changeRequirement(ChangePlanRequirementDescriptionRequest $request): JsonResponse
    {
        return $this->response($this->planService->changeRequirement(
            $request->planId,
            $request->requirementId,
            $request->description,
        ));
    }
}
