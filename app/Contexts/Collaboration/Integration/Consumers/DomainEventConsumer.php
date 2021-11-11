<?php

namespace App\Contexts\Collaboration\Integration\Consumers;

use App\Contexts\Collaboration\Domain\Events\Invite\InviteAccepted as DomainInviteAccepted;
use App\Contexts\Collaboration\Domain\Events\Invite\InviteDiscarded as DomainInviteDiscarded;
use App\Contexts\Collaboration\Domain\Events\Invite\InviteProposed as DomainInviteProposed;
use App\Contexts\Collaboration\Domain\Events\Relation\RelationEstablished as DomainRelationEstablished;
use App\Contexts\Collaboration\Domain\Events\Relation\RelationLeft as DomainRelationLeft;
use App\Contexts\Collaboration\Integration\Events\InviteAccepted;
use App\Contexts\Collaboration\Integration\Events\InviteDiscarded;
use App\Contexts\Collaboration\Integration\Events\InviteProposed;
use App\Contexts\Collaboration\Integration\Events\RelationEstablished;
use App\Contexts\Collaboration\Integration\Events\RelationLeft;
use App\Shared\Contracts\Messaging\EventConsumerInterface;
use App\Shared\Contracts\Messaging\EventInterface;
use App\Shared\Contracts\Messaging\IntegrationEventBusInterface;

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
