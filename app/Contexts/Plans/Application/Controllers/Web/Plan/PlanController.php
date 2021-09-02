<?php

namespace App\Contexts\Plans\Application\Controllers\Web\Plan;

use App\Contexts\Plans\Application\Controllers\Web\BaseController;
use App\Contexts\Plans\Application\Controllers\Web\Plan\Commands\{AddPlanRequest, ArchivePlanRequest, ChangePlanDescriptionRequest, LaunchPlanRequest, StopPlanRequest};
use App\Contexts\Plans\Application\Services\PlanAppService;
use Illuminate\Http\JsonResponse;

class PlanController extends BaseController
{
    public function __construct(
        private PlanAppService $planAppService
    ) {
    }

    public function add(AddPlanRequest $request): JsonResponse
    {
        return $this->response($this->planAppService->add(
            $request->workspaceId,
            $request->description,
        ));
    }

    public function launch(LaunchPlanRequest $request): JsonResponse
    {
        return $this->response($this->planAppService->launch(
            $request->planId,
        ));
    }

    public function stop(StopPlanRequest $request): JsonResponse
    {
        return $this->response($this->planAppService->stop(
            $request->planId,
        ));
    }

    public function archive(ArchivePlanRequest $request): JsonResponse
    {
        return $this->response($this->planAppService->archive(
            $request->planId,
        ));
    }

    public function changeDescription(ChangePlanDescriptionRequest $request): JsonResponse
    {
        return $this->response($this->planAppService->changeDescription(
            $request->planId,
            $request->description,
        ));
    }
}
