<?php

namespace Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace;

use Cardz\Support\MobileAppGateway\Application\Services\Workspace\CardAppService;
use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\BaseController;
use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Commands\Card\AchievementCardRequest;
use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Commands\Card\CardCommandRequest;
use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Commands\Card\IssueCardRequest;
use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Queries\GetCardRequest;
use Illuminate\Http\JsonResponse;

class CardController extends BaseController
{
    public function __construct(
        private CardAppService $cardService,
    ) {
    }

    public function getCard(GetCardRequest $request): JsonResponse
    {
        return $this->response($this->cardService->getCard($request->cardId));
    }

    public function issue(IssueCardRequest $request): JsonResponse
    {
        return $this->response($this->cardService->issue($request->planId, $request->customerId));
    }

    public function complete(CardCommandRequest $request): JsonResponse
    {
        return $this->response($this->cardService->complete($request->cardId));
    }

    public function revoke(CardCommandRequest $request): JsonResponse
    {
        return $this->response($this->cardService->revoke($request->cardId));
    }

    public function block(CardCommandRequest $request): JsonResponse
    {
        return $this->response($this->cardService->block($request->cardId));
    }

    public function unblock(CardCommandRequest $request): JsonResponse
    {
        return $this->response($this->cardService->unblock($request->cardId));
    }

    public function noteAchievement(AchievementCardRequest $request): JsonResponse
    {
        return $this->response($this->cardService->noteAchievement($request->cardId, $request->achievementId, $request->description));
    }

    public function dismissAchievement(AchievementCardRequest $request): JsonResponse
    {
        return $this->response($this->cardService->dismissAchievement($request->cardId, $request->achievementId));
    }

}
