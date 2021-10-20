<?php

namespace App\Contexts\Collaboration\Application\Consumers;

use App\Contexts\Collaboration\Domain\Events\Invite\InviteAccepted;
use App\Contexts\Collaboration\Domain\Events\Invite\InviteDiscarded;
use App\Contexts\Collaboration\Domain\Model\Invite\Invite;
use App\Contexts\Collaboration\Domain\Persistence\Contracts\InviteRepositoryInterface;
use App\Shared\Contracts\Messaging\EventConsumerInterface;
use App\Shared\Contracts\Messaging\EventInterface;

final class InviteCleanUpConsumer implements EventConsumerInterface
{
    public function __construct(
        private InviteRepositoryInterface $inviteRepository,
    ) {
    }

    public function consumes(): array
    {
        return [
            InviteAccepted::class,
            InviteDiscarded::class,
        ];
    }

    public function handle(EventInterface $event): void
    {
        /** @var Invite $invite */
        $invite = $event->with();
        $this->inviteRepository->remove($invite->inviteId);
    }

}
