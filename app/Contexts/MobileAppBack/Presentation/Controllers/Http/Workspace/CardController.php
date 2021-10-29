<?php

namespace App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace;

use App\Contexts\MobileAppBack\Application\Services\Workspace\CardAppService;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\BaseController;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Commands\Card\AchievementCardRequest;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Commands\Card\CardCommandRequest;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Commands\Card\IssueCardRequest;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Queries\GetCardRequest;
use App\Shared\Contracts\Commands\CommandBusInterface;
use App\Shared\Contracts\Queries\QueryBusInterface;
use Illuminate\Http\JsonResponse;

class CardController extends BaseController
{
    public function __construct(
        private CardAppService $cardService,
        private QueryBusInterface $queryBus,
        private CommandBusInterface $commandBus,
    ) {
    }

    public function getCard(GetCardRequest $request): JsonResponse
    {
        return $this->response($this->queryBus->execute($request->toQuery()));
    }

    public function issue(IssueCardRequest $request): JsonResponse
    {
        return $this->response($this->cardService->issue(
            $request->collaboratorId,
            $request->workspaceId,
            $request->planId,
            $request->customerId,
            $request->description,
        ));
    }

    public function complete(CardCommandRequest $request): JsonResponse
    {
        return $this->response($this->cardService->complete(
            $request->collaboratorId,
            $request->workspaceId,
            $request->cardId,
        ));
    }

    public function revoke(CardCommandRequest $request): JsonResponse
    {
        return $this->response($this->cardService->revoke(
            $request->collaboratorId,
            $request->workspaceId,
            $request->cardId,
        ));
    }

    public function block(CardCommandRequest $request): JsonResponse
    {
        return $this->response($this->cardService->block(
            $request->collaboratorId,
            $request->workspaceId,
            $request->cardId,
        ));
    }

    public function unblock(CardCommandRequest $request): JsonResponse
    {
        return $this->response($this->cardService->unblock(
            $request->collaboratorId,
            $request->workspaceId,
            $request->cardId,
        ));
    }

    public function noteAchievement(AchievementCardRequest $request): JsonResponse
    {
        return $this->response($this->cardService->noteAchievement(
            $request->collaboratorId,
            $request->workspaceId,
            $request->cardId,
            $request->achievementId,
            $request->description,
        ));
    }

    public function dismissAchievement(AchievementCardRequest $request): JsonResponse
    {
        return $this->response($this->cardService->dismissAchievement(
            $request->collaboratorId,
            $request->workspaceId,
            $request->cardId,
            $request->achievementId,
            $request->description,
        ));
    }

}
