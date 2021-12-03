<?php

namespace Cardz\Support\MobileAppGateway\Infrastructure\ACL\Collaboration;

use Cardz\Support\Collaboration\Application\Commands\Invite\AcceptInvite;
use Cardz\Support\Collaboration\Application\Commands\Invite\DiscardInvite;
use Cardz\Support\Collaboration\Application\Commands\Invite\ProposeInvite;
use Cardz\Support\Collaboration\Application\Commands\Relation\LeaveRelation;
use Cardz\Support\MobileAppGateway\Integration\Contracts\CollaborationContextInterface;
use Codderz\Platypus\Contracts\Commands\CommandBusInterface;

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
