<?php

namespace App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace;

use App\Contexts\MobileAppBack\Application\Controllers\Web\BaseController;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\Queries\CardByCodeRequest;
use App\Contexts\MobileAppBack\Application\Services\Plan\PlanService;
use Illuminate\Http\JsonResponse;

class CardController extends BaseController
{
    public function __construct(
        private PlanService $planService
    ) {
    }

    public function getCardByCode(CardByCodeRequest $request): JsonResponse
    {
        return $this->response($this->customerService->getCardByCode(
            $request->code,
        ));
    }

    public function completeCard(CompleteCardRequest $request): JsonResponse
    {
        return $this->success();
    }

    public function revokeCard(RevokeCardRequest $request): JsonResponse
    {
        return $this->success();
    }

    public function blockCard(BlockCardRequest $request): JsonResponse
    {
        return $this->success();
    }

    public function unblockCard(UnblockCardRequest $request): JsonResponse
    {
        return $this->success();
    }

    public function markAchievement(MarkAchievementRequest $request): JsonResponse
    {
        return $this->success();
    }

}
