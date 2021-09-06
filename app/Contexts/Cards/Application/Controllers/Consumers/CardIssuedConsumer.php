<?php

namespace App\Contexts\Cards\Application\Controllers\Consumers;

use App\Contexts\Cards\Application\Contracts\IssuedCardReadStorageInterface;
use App\Contexts\Cards\Application\IntegrationEvents\CardIssued;
use App\Contexts\Cards\Application\Services\CardAppService;
use App\Contexts\Cards\Infrastructure\ACL\Plans\PlansAdapter;
use App\Contexts\Shared\Contracts\Informable;
use App\Contexts\Shared\Contracts\Reportable;

final class CardIssuedConsumer implements Informable
{
    public function __construct(
        private IssuedCardReadStorageInterface $issuedCardReadStorage,
        private CardAppService $cardAppService,
        private PlansAdapter $plansAdapter,
    ) {
    }

    public function accepts(Reportable $reportable): bool
    {
        return $reportable instanceof CardIssued;
    }

    //ToDo: для Eventual Consistency что-то другое придётся изобретать
    public function inform(Reportable $reportable): void
    {
        /** @var CardIssued $event */
        $event = $reportable;
        $issuedCard = $this->issuedCardReadStorage->find($event->getInstanceId());
        if ($issuedCard === null) {
            return;
        }

        $requirements = $this->plansAdapter->getRequirements($issuedCard->planId);
        $this->cardAppService->acceptRequirements($issuedCard->cardId, ...$requirements->getPayload());
    }

}
