<?php

namespace App\Contexts\Collaboration\Application\Services;

use App\Contexts\Collaboration\Application\Commands\Invite\AcceptInvite;
use App\Contexts\Collaboration\Application\Commands\Invite\DiscardInvite;
use App\Contexts\Collaboration\Domain\Model\Invite\InviteId;
use App\Contexts\Collaboration\Domain\Persistence\Contracts\InviteRepositoryInterface;
use App\Contexts\Collaboration\Infrastructure\Messaging\DomainEventBusInterface;

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
