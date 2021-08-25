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
use App\Contexts\Cards\Domain\Model\Card\Card;
use App\Contexts\Cards\Infrasctructure\Messaging\ReportingBus;
use App\Contexts\Cards\Infrasctructure\Persistence\CardRepository;
use Illuminate\Http\JsonResponse;

class CardController extends BaseController
{
    public function __construct(
        private CardRepository $cardRepository,
        ReportingBus $reportingBus
    ) {
        parent::__construct($reportingBus);
    }

    public function generateCardCode(GenerateCardCodeRequest $generateCardCodeRequest): JsonResponse
    {
        return $this->successApiResponse(null, ['code' => base64_encode($generateCardCodeRequest->cardId)]);
    }

    public function issueCard(IssueCardRequest $issueCardRequest): JsonResponse
    {
        $card = Card::create(
            $issueCardRequest->cardId,
            $issueCardRequest->bonusProgramId,
            $issueCardRequest->customerId,
            $issueCardRequest->description,
        );
        $card->issue();
        $this->cardRepository->persist($card);
        return $this->successApiResponse(new CardIssued(), ['cardId' => (string) $card->cardId]);
    }

    public function completeCard(CompleteCardRequest $completeCardRequest): JsonResponse
    {
        $card = $this->cardRepository->take($completeCardRequest->cardId);
        $card?->complete();
        $this->cardRepository->persist($card);
        return $this->successApiResponse(new CardCompleted());
    }

    public function revokeCard(RevokeCardRequest $revokeCardRequest): JsonResponse
    {
        $card = $this->cardRepository->take($revokeCardRequest->cardId);
        $card?->revoke();
        $this->cardRepository->persist($card);
        return $this->successApiResponse(new CardRevoked());
    }

    public function blockCard(BlockCardRequest $blockCardRequest): JsonResponse
    {
        $card = $this->cardRepository->take($blockCardRequest->cardId);
        $card?->block();
        $this->cardRepository->persist($card);
        return $this->successApiResponse(new CardBlocked());
    }

    public function addAchievement(AddAchievementRequest $addAchievementRequest): JsonResponse
    {
        $card = $this->cardRepository->take($addAchievementRequest->cardId);
        $card?->noteAchievement($addAchievementRequest->description);
        $this->cardRepository->persist($card);
        return $this->successApiResponse(new AchievementNoted());
    }

    public function removeAchievement(RemoveAchievementRequest $removeAchievementRequest): JsonResponse
    {
        $card = $this->cardRepository->take($removeAchievementRequest->cardId);
        $card?->dismissAchievement($removeAchievementRequest->achievementId);
        $this->cardRepository->persist($card);
        return $this->successApiResponse(new AchievementDismissed());
    }

}
