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
use App\Contexts\Cards\Application\Controllers\Web\Card\Queries\GenerateCardCodeRequest;
use App\Contexts\Cards\Application\IntegrationEvents\AchievementDismissed;
use App\Contexts\Cards\Application\IntegrationEvents\AchievementNoted;
use App\Contexts\Cards\Application\IntegrationEvents\CardBlocked;
use App\Contexts\Cards\Application\IntegrationEvents\CardCompleted;
use App\Contexts\Cards\Application\IntegrationEvents\CardIssued;
use App\Contexts\Cards\Application\IntegrationEvents\CardRevoked;
use Illuminate\Http\JsonResponse;

class CardController extends BaseController
{
    public function generateCardCode(GenerateCardCodeRequest $generateCardCodeRequest): JsonResponse
    {
        return $this->successApiResponse(null, ['cardId' => (string) $generateCardCodeRequest->cardId]);
    }

    public function issueCard(IssueCardRequest $issueCardRequest): JsonResponse
    {
        return $this->successApiResponse(new CardIssued(), ['cardId' => (string) $issueCardRequest->cardId]);
    }

    public function completeCard(CompleteCardRequest $completeCardRequest): JsonResponse
    {
        return $this->successApiResponse(new CardCompleted());
    }

    public function revokeCard(RevokeCardRequest $revokeCardRequest): JsonResponse
    {
        return $this->successApiResponse(new CardRevoked());
    }

    public function blockCard(BlockCardRequest $blockCardRequest): JsonResponse
    {
        return $this->successApiResponse(new CardBlocked());
    }

    public function addAchievement(AddAchievementRequest $addAchievementRequest): JsonResponse
    {
        return $this->successApiResponse(new AchievementNoted());
    }

    public function removeAchievement(RemoveAchievementRequest $removeAchievementRequest): JsonResponse
    {
        return $this->successApiResponse(new AchievementDismissed());
    }

}
