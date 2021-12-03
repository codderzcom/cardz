<?php

namespace Cardz\Support\Collaboration\Integration\Consumers;

use Cardz\Support\Collaboration\Domain\Events\Invite\InviteAccepted as DomainInviteAccepted;
use Cardz\Support\Collaboration\Domain\Events\Invite\InviteDiscarded as DomainInviteDiscarded;
use Cardz\Support\Collaboration\Domain\Events\Invite\InviteProposed as DomainInviteProposed;
use Cardz\Support\Collaboration\Domain\Events\Relation\RelationEstablished as DomainRelationEstablished;
use Cardz\Support\Collaboration\Domain\Events\Relation\RelationLeft as DomainRelationLeft;
use Cardz\Support\Collaboration\Integration\Events\InviteAccepted;
use Cardz\Support\Collaboration\Integration\Events\InviteDiscarded;
use Cardz\Support\Collaboration\Integration\Events\InviteProposed;
use Cardz\Support\Collaboration\Integration\Events\RelationEstablished;
use Cardz\Support\Collaboration\Integration\Events\RelationLeft;
use Codderz\Platypus\Contracts\Messaging\EventConsumerInterface;
use Codderz\Platypus\Contracts\Messaging\EventInterface;
use Codderz\Platypus\Contracts\Messaging\IntegrationEventBusInterface;

final class DomainEventConsumer implements EventConsumerInterface
{
    public function __construct(
        private IntegrationEventBusInterface $integrationEventBus
    ) {
    }

    public function consumes(): array
    {
        return [
            DomainInviteAccepted::class,
            DomainInviteDiscarded::class,
            DomainInviteProposed::class,

            DomainRelationEstablished::class,
            DomainRelationLeft::class,
        ];
    }

    public function handle(EventInterface $event): void
    {
        $integrationEvent = match ($event::class) {
            DomainInviteAccepted::class => InviteAccepted::of($event->with()),
            DomainInviteDiscarded::class => InviteDiscarded::of($event->with()),
            DomainInviteProposed::class => InviteProposed::of($event->with()),

            DomainRelationEstablished::class => RelationEstablished::of($event->with()),
            DomainRelationLeft::class => RelationLeft::of($event->with()),
            default => null,
        };
        if ($integrationEvent !== null) {
            $this->integrationEventBus->publish($integrationEvent);
        }
    }

}
