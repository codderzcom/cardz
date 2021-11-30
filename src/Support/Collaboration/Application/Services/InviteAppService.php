<?php

namespace Cardz\Support\Collaboration\Application\Services;

use Cardz\Support\Collaboration\Application\Commands\Invite\AcceptInvite;
use Cardz\Support\Collaboration\Application\Commands\Invite\DiscardInvite;
use Cardz\Support\Collaboration\Domain\Model\Invite\InviteId;
use Cardz\Support\Collaboration\Domain\Persistence\Contracts\InviteRepositoryInterface;
use Cardz\Support\Collaboration\Infrastructure\Messaging\DomainEventBusInterface;

class InviteAppService
{
    public function __construct(
        private InviteRepositoryInterface $inviteRepository,
        private DomainEventBusInterface $domainEventBus,
    ) {
    }

    public function accept(AcceptInvite $command): InviteId
    {
        $invite = $this->inviteRepository->take($command->getInviteId());
        $invite->accept($command->getCollaboratorId());
        $this->inviteRepository->persist($invite);
        $this->domainEventBus->publish(...$invite->releaseEvents());
        return $invite->inviteId;
    }

    public function discard(DiscardInvite $command): InviteId
    {
        $invite = $this->inviteRepository->take($command->getInviteId());
        $invite->discard();
        $this->inviteRepository->persist($invite);
        $this->domainEventBus->publish(...$invite->releaseEvents());
        return $invite->inviteId;
    }
}
