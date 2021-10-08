<?php

namespace App\Contexts\Cards\Application\Controllers\Consumers;

use App\Contexts\Cards\Application\Services\CardAppService;
use App\Contexts\Cards\Infrastructure\ReadStorage\Contracts\IssuedCardReadStorageInterface;
use App\Contexts\Cards\Infrastructure\ReadStorage\Contracts\ReadPlanStorageInterface;
use App\Contexts\Cards\Integration\Events\CardIssued;
use App\Shared\Contracts\Informable;
use App\Shared\Contracts\Reportable;

final class CardIssuedConsumer implements Informable
{
    public function __construct(
        private IssuedCardReadStorageInterface $issuedCardReadStorage,
        private ReadPlanStorageInterface $readPlanStorage,
        private CardAppService $cardAppService,
    ) {
    }

    public function accepts(Reportable $reportable): bool
    {
        return $reportable instanceof CardIssued;
    }

    public function inform(Reportable $reportable): void
    {
        /** @var CardIssued $event */
        $event = $reportable;
        $issuedCard = $this->issuedCardReadStorage->find($event->id());
        if ($issuedCard === null) {
            return;
        }

        $plan = $this->readPlanStorage->take($issuedCard->planId);
        if ($plan === null) {
            return;
        }

        $this->cardAppService->acceptRequirements($issuedCard->cardId, ...$plan->requirements);
    }

}
