<?php

namespace App\Contexts\MobileAppBack\Application\Controllers\Web\Card;

use App\Contexts\MobileAppBack\Application\Controllers\Web\BaseController;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Card\Queries\CardByCodeRequest;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Card\Queries\CardRequest;
use App\Contexts\MobileAppBack\Application\Controllers\Web\Card\Queries\GenerateCardCodeRequest;
use App\Contexts\MobileAppBack\Application\Services\Card\CardService;
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

    public function getCard(CardRequest $request): JsonResponse
    {
        return $this->response($this->cardService->getCard(
            $request->cardId,
        ));
    }

    public function generateCode(GenerateCardCodeRequest $request): JsonResponse
    {
        return $this->response($this->cardService->getCardCode(
            $request->cardId,
        ));
    }

    public function issueCard(IssueCardRequest $request): JsonResponse
    {
        return $this->success();
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

    public function listAllAchievements(ListAllAchievementsRequest $request): JsonResponse
    {
        return $this->success();
    }

    public function markAchievement(MarkAchievementRequest $request): JsonResponse
    {
        return $this->success();
    }
}
