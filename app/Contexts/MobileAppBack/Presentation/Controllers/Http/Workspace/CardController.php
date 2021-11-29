<?php

namespace App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace;

use App\Contexts\Authorization\Domain\Permissions\AuthorizationPermission;
use App\Contexts\MobileAppBack\Application\Services\AuthorizationServiceInterface;
use App\Contexts\MobileAppBack\Application\Services\Workspace\CardAppService;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\BaseController;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Commands\Card\AchievementCardRequest;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Commands\Card\CardCommandRequest;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Commands\Card\IssueCardRequest;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Queries\GetCardRequest;
use App\Shared\Contracts\GeneralIdInterface;
use Illuminate\Http\JsonResponse;

class CardController extends BaseController
{
    public function __construct(
        private CardAppService $cardService,
        private AuthorizationServiceInterface $authorizationService,
    ) {
    }

    public function getCard(GetCardRequest $request): JsonResponse
    {
        $this->authorizationService->authorize(
            AuthorizationPermission::CARD_VIEW(),
            $request->collaboratorId,
            $request->cardId,
        );

        return $this->response($this->cardService->getCard($request->cardId));
    }

    public function issue(IssueCardRequest $request): JsonResponse
    {
        $this->authorizationService->authorize(
            AuthorizationPermission::PLAN_CARD_ADD(),
            $request->collaboratorId,
            $request->planId,
        );

        return $this->response($this->cardService->issue($request->planId, $request->customerId));
    }

    public function complete(CardCommandRequest $request): JsonResponse
    {
        $this->authorizeCardChange($request->collaboratorId, $request->cardId);
        return $this->response($this->cardService->complete($request->cardId));
    }

    public function revoke(CardCommandRequest $request): JsonResponse
    {
        $this->authorizeCardChange($request->collaboratorId, $request->cardId);
        return $this->response($this->cardService->revoke($request->cardId));
    }

    public function block(CardCommandRequest $request): JsonResponse
    {
        $this->authorizeCardChange($request->collaboratorId, $request->cardId);
        return $this->response($this->cardService->block($request->cardId));
    }

    public function unblock(CardCommandRequest $request): JsonResponse
    {
        $this->authorizeCardChange($request->collaboratorId, $request->cardId);
        return $this->response($this->cardService->unblock($request->cardId));
    }

    public function noteAchievement(AchievementCardRequest $request): JsonResponse
    {
        $this->authorizeCardChange($request->collaboratorId, $request->cardId);
        return $this->response($this->cardService->noteAchievement($request->cardId, $request->achievementId, $request->description));
    }

    public function dismissAchievement(AchievementCardRequest $request): JsonResponse
    {
        $this->authorizeCardChange($request->collaboratorId, $request->cardId);
        return $this->response($this->cardService->dismissAchievement($request->cardId, $request->achievementId));
    }

    private function authorizeCardChange(GeneralIdInterface $collaboratorId, GeneralIdInterface $cardId): void
    {
        $this->authorizationService->authorize(
            AuthorizationPermission::CARD_CHANGE(),
            $collaboratorId,
            $cardId,
        );
    }

}
