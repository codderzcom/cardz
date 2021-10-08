<?php

namespace App\Contexts\Cards\Application\Services;

use App\Contexts\Cards\Domain\Model\BlockedCard\BlockedCardId;
use App\Contexts\Cards\Infrastructure\Persistence\Contracts\BlockedCardRepositoryInterface;
use App\Contexts\Cards\Integration\Events\{CardUnblocked};
use App\Shared\Contracts\ReportingBusInterface;
use App\Shared\Contracts\ServiceResultFactoryInterface;
use App\Shared\Contracts\ServiceResultInterface;
use App\Shared\Infrastructure\Support\ReportingServiceTrait;

class BlockedCardAppService
{
    use ReportingServiceTrait;

    public function __construct(
        private BlockedCardRepositoryInterface $blockedCardRepository,
        private ReportingBusInterface $reportingBus,
        private ServiceResultFactoryInterface $resultFactory,
    ) {
    }

    public function unblockCard(string $blockedCardId): ServiceResultInterface
    {
        $blockedCard = $this->blockedCardRepository->take(BlockedCardId::of($blockedCardId));
        if ($blockedCard === null) {
            return $this->resultFactory->notFound("$blockedCardId not found");
        }

        $blockedCard->unblock();
        $this->blockedCardRepository->persist($blockedCard);

        $result = $this->resultFactory->ok($blockedCard, new CardUnblocked($blockedCard->blockedCardId));
        return $this->reportResult($result, $this->reportingBus);
    }
}
