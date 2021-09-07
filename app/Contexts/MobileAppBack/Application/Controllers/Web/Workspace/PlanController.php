<?php

namespace App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace;

use App\Contexts\MobileAppBack\Application\Controllers\Web\BaseController;
use App\Contexts\MobileAppBack\Application\Services\Workspace\PlanService;
use App\Models\Plan as EloquentPlan;
use Illuminate\Http\JsonResponse;

class PlanController extends BaseController
{
    public function __construct(
        private PlanService $planService
    ) {
    }

    public function listAll(ListAllPlansRequest $request): JsonResponse
    {
        $plans = EloquentPlan::query()->where('workspaceId', '=', $request->workspaceId);
        return $this->success($plans);
    }

    public function getPlan(PlanRequest $request): JsonResponse
    {
        $plan = EloquentPlan::query()->find($request->planId);
        if ($plan === null) {
            return $this->notFound();
        }
        return $this->success($plan->toArray());
    }

    public function add(AddPlanRequest $request): JsonResponse
    {
        $this->planService->addPlan($request->description, $request->avhievements);
        $this->success();
    }

    public function setDescription(SetDescriptionRequest $request): JsonResponse
    {
        $this->planService->setDescription($request->planId, $request->description);
        $this->success();
    }

    public function setAchievements(SetAchievementsRequest $request): JsonResponse
    {
        $this->planService->setAchievements($request->planId, $request->avhievements);
        $this->success();
    }

    public function launchPlan(LaunchPlanRequest $request): JsonResponse
    {
        $this->planService->launchPlan($request->planId);
        $this->success();
    }

    public function stopPlan(StopPlanRequest $request): JsonResponse
    {
        $this->planService->stopPlan($request->planId);
        $this->success();
    }
}
