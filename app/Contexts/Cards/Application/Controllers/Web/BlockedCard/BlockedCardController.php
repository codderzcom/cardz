<?php

namespace App\Contexts\Cards\Application\Controllers\Web\BlockedCard;

use App\Contexts\Cards\Application\Contracts\BlockedCardRepositoryInterface;
use App\Contexts\Cards\Application\Controllers\Web\BaseController;
use App\Contexts\Cards\Application\Controllers\Web\BlockedCard\Commands\UnblockBlockedCardRequest;
use App\Contexts\Cards\Application\IntegrationEvents\CardUnblocked;
use App\Contexts\Shared\Contracts\ReportingBusInterface;
use Illuminate\Http\JsonResponse;

class BlockedCardController extends BaseController
{
    public function __construct(
        private BlockedCardRepositoryInterface $blockedCardRepository,
        ReportingBusInterface $reportingBus
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
