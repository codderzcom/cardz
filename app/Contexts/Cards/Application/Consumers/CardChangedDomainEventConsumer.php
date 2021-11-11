<?php

namespace App\Contexts\Cards\Application\Consumers;

use App\Contexts\Cards\Domain\Events\Card\AchievementDismissed as DomainAchievementDismissed;
use App\Contexts\Cards\Domain\Events\Card\AchievementNoted as DomainAchievementNoted;
use App\Contexts\Cards\Domain\Events\Card\CardBlocked as DomainCardBlocked;
use App\Contexts\Cards\Domain\Events\Card\CardCompleted as DomainCardCompleted;
use App\Contexts\Cards\Domain\Events\Card\CardIssued as DomainCardIssued;
use App\Contexts\Cards\Domain\Events\Card\CardRevoked as DomainCardRevoked;
use App\Contexts\Cards\Domain\Events\Card\CardSatisfactionWithdrawn as DomainCardSatisfactionWithdrawn;
use App\Contexts\Cards\Domain\Events\Card\CardSatisfied as DomainCardSatisfied;
use App\Contexts\Cards\Domain\Events\Card\CardUnblocked as DomainCardUnblocked;
use App\Contexts\Cards\Domain\Events\Card\RequirementsAccepted as DomainRequirementsAccepted;
use App\Contexts\Cards\Domain\Model\Card\Card;
use App\Contexts\Cards\Domain\ReadModel\IssuedCard;
use App\Contexts\Cards\Integration\Events\AchievementDismissed;
use App\Contexts\Cards\Integration\Events\AchievementNoted;
use App\Contexts\Cards\Integration\Events\CardBlocked;
use App\Contexts\Cards\Integration\Events\CardCompleted;
use App\Contexts\Cards\Integration\Events\CardIssued;
use App\Contexts\Cards\Integration\Events\CardRevoked;
use App\Contexts\Cards\Integration\Events\CardSatisfactionWithdrawn;
use App\Contexts\Cards\Integration\Events\CardSatisfied;
use App\Contexts\Cards\Integration\Events\CardUnblocked;
use App\Contexts\Cards\Integration\Events\RequirementsAccepted;
use App\Shared\Contracts\Messaging\EventConsumerInterface;
use App\Shared\Contracts\Messaging\EventInterface;
use App\Shared\Contracts\Messaging\IntegrationEventBusInterface;

class CardChangedDomainEventConsumer implements EventConsumerInterface
{
    public function __construct(
        private IntegrationEventBusInterface $integrationEventBus,
    ) {
    }

    public function consumes(): array
    {
        return [
            DomainAchievementDismissed::class,
            DomainAchievementNoted::class,
            DomainCardBlocked::class,
            DomainCardCompleted::class,
            DomainCardIssued::class,
            DomainCardRevoked::class,
            DomainCardSatisfactionWithdrawn::class,
            DomainCardSatisfied::class,
            DomainCardUnblocked::class,
            DomainRequirementsAccepted::class,
        ];
    }

    public function handle(EventInterface $event): void
    {
        /** @var Card $card */
        $card = $event->with();

        $integrationEvent = match (true) {
            $event instanceof DomainAchievementDismissed => AchievementDismissed::of(IssuedCard::from($card)),
            $event instanceof DomainAchievementNoted => AchievementNoted::of(IssuedCard::from($card)),
            $event instanceof DomainCardBlocked => CardBlocked::of(IssuedCard::from($card)),
            $event instanceof DomainCardCompleted => CardCompleted::of(IssuedCard::from($card)),
            $event instanceof DomainCardIssued => CardIssued::of(IssuedCard::from($card)),
            $event instanceof DomainCardRevoked => CardRevoked::of(IssuedCard::from($card)),
            $event instanceof DomainCardSatisfactionWithdrawn => CardSatisfactionWithdrawn::of(IssuedCard::from($card)),
            $event instanceof DomainCardSatisfied => CardSatisfied::of(IssuedCard::from($card)),
            $event instanceof DomainCardUnblocked => CardUnblocked::of(IssuedCard::from($card)),
            $event instanceof DomainRequirementsAccepted => RequirementsAccepted::of(IssuedCard::from($card)),
            default => null,
        };

        if ($integrationEvent !== null) {
            $this->integrationEventBus->publish($integrationEvent);
        }
    }

}
