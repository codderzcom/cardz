<?php

namespace App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace;

use App\Contexts\MobileAppBack\Application\Controllers\Web\BaseController;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\Commands\DismissAchievementCardRequest;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\Commands\AchievementCardRequest;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\Commands\CardCommandRequest;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\Commands\IssueCardRequest;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\Queries\CardByCodeRequest;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\Queries\CardByIdRequest;
use App\Contexts\MobileAppBack\Application\Services\Workspace\CardService;
use Illuminate\Http\JsonResponse;

class CardController extends BaseController
{
    public function __construct(
        private CardService $cardService,
    ) {
    }

    public function getCardByCode(CardByCodeRequest $request): JsonResponse
    {
        return $this->response($this->cardService->getCardByCode(
            $request->code,
        ));
    }

    public function getCardById(CardByIdRequest $request): JsonResponse
    {
        return $this->response($this->cardService->getCardByCode(
            $request->cardId,
        ));
    }

    public function issue(IssueCardRequest $request): JsonResponse
    {
        return $this->response($this->cardService->issue(
            $request->workspaceId,
            $request->planId,
            $request->customerId,
            $request->description,
        ));
    }

    public function complete(CardCommandRequest $request): JsonResponse
    {
        return $this->response($this->cardService->complete(
            $request->workspaceId,
            $request->cardId,
        ));
    }

    public function revoke(CardCommandRequest $request): JsonResponse
    {
        return $this->response($this->cardService->revoke(
            $request->workspaceId,
            $request->cardId,
        ));
    }

    public function block(CardCommandRequest $request): JsonResponse
    {
        return $this->response($this->cardService->block(
            $request->workspaceId,
            $request->cardId,
        ));
    }

    public function unblock(CardCommandRequest $request): JsonResponse
    {
        return $this->response($this->cardService->unblock(
            $request->workspaceId,
            $request->cardId,
        ));
    }

    public function noteAchievement(AchievementCardRequest $request): JsonResponse
    {
        return $this->response($this->cardService->noteAchievement(
            $request->workspaceId,
            $request->cardId,
            $request->achievementId,
            $request->description,
        ));
    }

    public function dismissAchievement(AchievementCardRequest $request): JsonResponse
    {
        return $this->response($this->cardService->dismissAchievement(
            $request->workspaceId,
            $request->cardId,
            $request->achievementId,
            $request->description,
        ));
    }

}
