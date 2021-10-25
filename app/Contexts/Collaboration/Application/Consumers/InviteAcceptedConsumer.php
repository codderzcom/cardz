<?php

namespace App\Contexts\Collaboration\Application\Consumers;

use App\Contexts\Collaboration\Application\Commands\Relation\EstablishRelation;
use App\Contexts\Collaboration\Domain\Events\Invite\InviteAccepted;
use App\Contexts\Collaboration\Domain\Model\Invite\Invite;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationType;
use App\Shared\Contracts\Commands\CommandBusInterface;
use App\Shared\Contracts\Messaging\EventConsumerInterface;
use App\Shared\Contracts\Messaging\EventInterface;

final class InviteAcceptedConsumer implements EventConsumerInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
    ) {
    }

    public function consumes(): array
    {
        return [
            InviteAccepted::class,
        ];
    }

    public function handle(EventInterface $event): void
    {
        /** @var Invite $invite */
        $invite = $event->with();
        $this->commandBus->dispatch(EstablishRelation::of($invite->getCollaboratorId(), $invite->workspaceId, RelationType::MEMBER()));
    }

}
