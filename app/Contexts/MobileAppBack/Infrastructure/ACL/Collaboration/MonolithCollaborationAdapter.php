<?php

namespace App\Contexts\MobileAppBack\Infrastructure\ACL\Collaboration;

use App\Contexts\Collaboration\Application\Commands\Invite\AcceptInvite;
use App\Contexts\Collaboration\Application\Commands\Invite\DiscardInvite;
use App\Contexts\Collaboration\Application\Commands\Invite\ProposeInvite;
use App\Contexts\Collaboration\Application\Commands\Relation\LeaveRelation;
use App\Contexts\MobileAppBack\Integration\Contracts\CollaborationContextInterface;
use App\Shared\Contracts\Commands\CommandBusInterface;

class MonolithCollaborationAdapter implements CollaborationContextInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
    ) {
    }

    public function propose(string $collaboratorId, string $workspaceId): string
    {
        $command = ProposeInvite::of($collaboratorId, $workspaceId);
        $this->commandBus->dispatch($command);
        return $command->getInviteId();
    }

    public function accept(string $inviteId, string $collaboratorId): string
    {
        $command = AcceptInvite::of($inviteId, $collaboratorId);
        $this->commandBus->dispatch($command);
        return $command->getInviteId();
    }

    public function discard(string $inviteId): string
    {
        $command = DiscardInvite::of($inviteId);
        $this->commandBus->dispatch($command);
        return $command->getInviteId();
    }

    public function leave(string $collaboratorId, string $workspaceId): string
    {
        $command = LeaveRelation::of($collaboratorId, $workspaceId);
        $this->commandBus->dispatch($command);
        return $command->getCollaboratorId();
    }

}
