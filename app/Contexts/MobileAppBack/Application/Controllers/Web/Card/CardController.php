<?php

namespace App\Contexts\MobileAppBack\Application\Controllers\Web\Card;

use App\Contexts\MobileAppBack\Application\Controllers\Web\BaseController;
use Illuminate\Http\JsonResponse;

class CardController extends BaseController
{
    public function getCard(getCardRequest $request): JsonResponse
    {
        return $this->success();
    }

    public function generateCode(GenerateCardCodeRequest $request): JsonResponse
    {
        return $this->success();
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
