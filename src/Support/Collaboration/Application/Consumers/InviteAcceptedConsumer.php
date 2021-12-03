<?php

namespace Cardz\Support\Collaboration\Application\Consumers;

use Cardz\Support\Collaboration\Application\Commands\Relation\EstablishRelation;
use Cardz\Support\Collaboration\Domain\Events\Invite\InviteAccepted;
use Cardz\Support\Collaboration\Domain\Model\Invite\Invite;
use Cardz\Support\Collaboration\Domain\Model\Relation\RelationType;
use Codderz\Platypus\Contracts\Commands\CommandBusInterface;
use Codderz\Platypus\Contracts\Messaging\EventConsumerInterface;
use Codderz\Platypus\Contracts\Messaging\EventInterface;

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
