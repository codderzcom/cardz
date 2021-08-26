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
use App\Contexts\Cards\Infrasctructure\Persistence\CardRepository;
use App\Contexts\Shared\Contracts\ReportingBusInterface;
use Illuminate\Http\JsonResponse;

class CardController extends BaseController
{
    public function __construct(
        private CardRepository $cardRepository,
        ReportingBusInterface $reportingBus
    ) {
        parent::__construct($reportingBus);
    }

    public function generateCardCode(GenerateCardCodeRequest $generateCardCodeRequest): JsonResponse
    {
        return $this->success(null, ['code' => base64_encode($generateCardCodeRequest->cardId)]);
    }

    public function issueCard(IssueCardRequest $request): JsonResponse
    {
        $card = Card::create(
            $request->cardId,
            $request->bonusProgramId,
            $request->customerId,
            $request->description,
        );
        $card->issue();
        $this->cardRepository->persist($card);
        return $this->success(new CardIssued($request->cardId, 'Card'), ['cardId' => (string) $card->cardId]);
    }

    public function completeCard(CompleteCardRequest $request): JsonResponse
    {
        $card = $this->cardRepository->take($request->cardId);
        if ($card === null) {
            return $this->notFound(['cardId' => (string) $request->cardId]);
        }

        $card?->complete();
        $this->cardRepository->persist($card);
        return $this->success(new CardCompleted($request->cardId, 'Card'));
    }

    public function revokeCard(RevokeCardRequest $request): JsonResponse
    {
        $card = $this->cardRepository->take($request->cardId);
        if ($card === null) {
            return $this->notFound(['cardId' => (string) $request->cardId]);
        }

        $card?->revoke();
        $this->cardRepository->persist($card);
        return $this->success(new CardRevoked($request->cardId, 'Card'));
    }

    public function blockCard(BlockCardRequest $request): JsonResponse
    {
        $card = $this->cardRepository->take($request->cardId);
        if ($card === null) {
            return $this->notFound(['cardId' => (string) $request->cardId]);
        }

        $card?->block();
        $this->cardRepository->persist($card);
        return $this->success(new CardBlocked($request->cardId, 'Card'));
    }

    public function addAchievement(AddAchievementRequest $request): JsonResponse
    {
        $card = $this->cardRepository->take($request->cardId);
        if ($card === null) {
            return $this->notFound(['cardId' => (string) $request->cardId]);
        }

        $card?->noteAchievement($request->description);
        $this->cardRepository->persist($card);
        return $this->success(new AchievementNoted($request->cardId, 'Card'));
    }

    public function removeAchievement(RemoveAchievementRequest $request): JsonResponse
    {
        $card = $this->cardRepository->take($request->cardId);
        if ($card === null) {
            return $this->notFound(['cardId' => (string) $request->cardId]);
        }

        $card?->dismissAchievement($request->achievementId);
        $this->cardRepository->persist($card);
        return $this->success(new AchievementDismissed($request->cardId, 'Card'));
    }

}
