<?php

namespace App\Contexts\Collaboration\Application\Services;

use App\Contexts\Collaboration\Application\Commands\Invite\AcceptInviteCommandInterface;
use App\Contexts\Collaboration\Application\Commands\Invite\DiscardInviteCommandInterface;
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

    public function accept(AcceptInviteCommandInterface $command): InviteId
    {
        $invite = $this->inviteRepository->take($command->getInviteId());
        $invite->accept($command->getCollaboratorId());
        $this->inviteRepository->persist($invite);
        $this->domainEventBus->publish(...$invite->releaseEvents());
        return $invite->inviteId;
    }

    public function discard(DiscardInviteCommandInterface $command): InviteId
    {
        $invite = $this->inviteRepository->take($command->getInviteId());
        $invite->discard();
        $this->inviteRepository->persist($invite);
        $this->domainEventBus->publish(...$invite->releaseEvents());
        return $invite->inviteId;
    }
}
