<?php

namespace App\Contexts\Cards\Application\Controllers\Web\Card;

use App\Contexts\Cards\Application\Controllers\Web\BaseController;
use App\Contexts\Cards\Application\Controllers\Web\Card\Commands\{AddAchievementCommand,
    BlockCardCommand,
    CompleteCardCommand,
    IssueCardCommand,
    RemoveAchievementCommand,
    RevokeCardCommand
};
use App\Contexts\Cards\Application\Controllers\Web\Card\Queries\GenerateCardCodeQuery;
use App\Contexts\Cards\Application\IntegrationEvents\AchievementDismissed;
use App\Contexts\Cards\Application\IntegrationEvents\AchievementNoted;
use App\Contexts\Cards\Application\IntegrationEvents\CardBlocked;
use App\Contexts\Cards\Application\IntegrationEvents\CardCompleted;
use App\Contexts\Cards\Application\IntegrationEvents\CardIssued;
use App\Contexts\Cards\Application\IntegrationEvents\CardRevoked;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CardController extends BaseController
{
    public function generateCardCode(GenerateCardCodeQuery $generateCardCodeQuery): JsonResponse
    {
        return $this->successApiResponse(null, (string) $generateCardCodeQuery->cardId);
    }

    public function issueCard(IssueCardCommand $issueCardCommand): JsonResponse
    {
        return $this->successApiResponse(new CardIssued());
    }

    public function completeCard(CompleteCardCommand $completeCardCommand): JsonResponse
    {
        return $this->successApiResponse(new CardCompleted());
    }

    public function revokeCard(RevokeCardCommand $revokeCardCommand): JsonResponse
    {
        return $this->successApiResponse(new CardRevoked());
    }

    public function blockCard(BlockCardCommand $blockCardCommand): JsonResponse
    {
        return $this->successApiResponse(new CardBlocked());
    }

    public function addAchievement(AddAchievementCommand $addAchievementCommand): JsonResponse
    {
        return $this->successApiResponse(new AchievementNoted());
    }

    public function removeAchievement(RemoveAchievementCommand $removeAchievementCommand): JsonResponse
    {
        return $this->successApiResponse(new AchievementDismissed());
    }

}
