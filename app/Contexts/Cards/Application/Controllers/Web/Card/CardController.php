<?php

namespace App\Contexts\Cards\Application\Controllers\Web\Card;

use App\Contexts\Cards\Application\Controllers\Web\BaseController;
use App\Contexts\Cards\Application\Controllers\Web\Card\Commands\{AddAchievementRequest,
    BlockCardRequest,
    CompleteCardRequest,
    IssueCardRequest,
    RemoveAchievementRequest,
    RevokeCardRequest
};
use App\Contexts\Cards\Application\Services\CardAppService;
use Illuminate\Http\JsonResponse;

class CardController extends BaseController
{
    public function __construct(
        private CardAppService $cardAppService,
    ) {
    }

    public function issue(IssueCardRequest $request)
    {
        return $this->response($this->cardAppService->issueCard(
            $request->planId,
            $request->customerId,
            $request->description,
        ));
    }

    public function complete(CompleteCardRequest $request): JsonResponse
    {
        return $this->response($this->cardAppService->completeCard(
            $request->cardId,
        ));
    }

    public function revoke(RevokeCardRequest $request): JsonResponse
    {
        return $this->response($this->cardAppService->revokeCard(
            $request->cardId,
        ));
    }

    public function block(BlockCardRequest $request): JsonResponse
    {
        return $this->response($this->cardAppService->blockCard(
            $request->cardId,
        ));
    }

    public function addAchievement(AddAchievementRequest $request): JsonResponse
    {
        return $this->response($this->cardAppService->noteAchievement(
            $request->cardId,
            $request->requirementId,
            $request->achievementDescription,
        ));
    }

    public function removeAchievement(RemoveAchievementRequest $request): JsonResponse
    {
        return $this->response($this->cardAppService->dismissAchievement(
            $request->cardId,
            $request->requirementId
        ));
    }

}
