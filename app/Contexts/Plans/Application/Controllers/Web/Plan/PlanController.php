<?php

namespace App\Contexts\Plans\Application\Controllers\Web\Plan;

use App\Contexts\Plans\Application\Contracts\PlanRepositoryInterface;
use App\Contexts\Plans\Application\Controllers\Web\BaseController;
use App\Contexts\Plans\Application\Controllers\Web\Plan\Commands\AddPlanRequest;
use App\Contexts\Plans\Application\Controllers\Web\Plan\Commands\ArchivePlanRequest;
use App\Contexts\Plans\Application\Controllers\Web\Plan\Commands\ChangePlanDescriptionRequest;
use App\Contexts\Plans\Application\Controllers\Web\Plan\Commands\LaunchPlanRequest;
use App\Contexts\Plans\Application\Controllers\Web\Plan\Commands\StopPlanRequest;
use App\Contexts\Plans\Application\IntegrationEvents\PlanAdded;
use App\Contexts\Plans\Application\IntegrationEvents\PlanArchived;
use App\Contexts\Plans\Application\IntegrationEvents\PlanLaunched;
use App\Contexts\Plans\Application\IntegrationEvents\PlanStopped;
use App\Contexts\Shared\Contracts\ReportingBusInterface;
use Illuminate\Http\JsonResponse;

class PlanController extends BaseController
{
    public function __construct(
        private PlanRepositoryInterface $planRepository,
        ReportingBusInterface $reportingBus
    )
    {
        parent::__construct($reportingBus);
    }

    public function add(AddPlanRequest $request): JsonResponse
    {
        $plan = $this->planRepository->take($request->planId);
        $plan?->add();
        return $this->success(new PlanAdded($plan?->planId, 'Plan'));
    }

    public function launch(LaunchPlanRequest $request): JsonResponse
    {
        $plan = $this->planRepository->take($request->planId);
        $plan?->launch();
        return $this->success(new PlanLaunched($plan?->planId, 'Plan'));
    }

    public function stop(StopPlanRequest $request): JsonResponse
    {
        $plan = $this->planRepository->take($request->planId);
        $plan?->stop();
        return $this->success(new PlanStopped($plan?->planId, 'Plan'));
    }

    public function archive(ArchivePlanRequest $request): JsonResponse
    {
        $plan = $this->planRepository->take($request->planId);
        $plan?->archive();
        return $this->success(new PlanArchived($plan?->planId, 'Plan'));
    }

    public function changeDescription(ChangePlanDescriptionRequest $request): JsonResponse
    {
        $plan = $this->planRepository->take($request->planId);
        $plan?->changeDescription($request->description);
        return $this->success(new PlanArchived($plan?->planId, 'Plan'));
    }
}
