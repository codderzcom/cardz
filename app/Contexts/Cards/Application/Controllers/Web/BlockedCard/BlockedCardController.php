<?php

namespace App\Contexts\Cards\Application\Controllers\Web\BlockedCard;

use App\Contexts\Cards\Application\Controllers\Web\BaseController;
use App\Contexts\Cards\Application\Controllers\Web\BlockedCard\Commands\UnblockBlockedCardRequest;
use App\Contexts\Cards\Application\IntegrationEvents\CardUnblocked;
use App\Contexts\Cards\Infrasctructure\Messaging\ReportingBus;
use App\Contexts\Cards\Infrasctructure\Persistence\BlockedCardRepository;
use Illuminate\Http\JsonResponse;

class BlockedCardController extends BaseController
{
    public function __construct(
        private BlockedCardRepository $blockedCardRepository,
        ReportingBus $reportingBus
    ) {
        parent::__construct($reportingBus);
    }

    public function unblockBlockedCard(UnblockBlockedCardRequest $request): JsonResponse
    {
        $blockedCard = $this->blockedCardRepository->take($request->blockedCardId);
        if ($blockedCard === null) {
            return $this->notFound(['blockedCardId' => $request->blockedCardId]);
        }

        $blockedCard->unblock();
        $this->blockedCardRepository->persist($blockedCard);
        return $this->success(new CardUnblocked($request->blockedCardId, 'BlockedCard'));
    }
}
