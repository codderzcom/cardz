<?php

namespace App\Contexts\Collaboration\Application\Consumers;

use App\Contexts\Collaboration\Domain\Events\Invite\InviteAccepted;
use App\Contexts\Collaboration\Domain\Events\Invite\InviteDiscarded;
use App\Contexts\Collaboration\Domain\Events\Invite\InviteRejected;
use App\Shared\Contracts\Messaging\EventConsumerInterface;
use App\Shared\Contracts\Messaging\EventInterface;

final class InviteCleanUpConsumer implements EventConsumerInterface
{
    public function consumes(): array
    {
        return [
            InviteAccepted::class,
            InviteRejected::class,
            InviteDiscarded::class,
        ];
    }

    public function handle(EventInterface $event): void
    {
        // TODO: Implement handle() method.
    }

}
