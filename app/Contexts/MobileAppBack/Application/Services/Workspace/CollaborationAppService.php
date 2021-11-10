<?php

namespace App\Contexts\MobileAppBack\Application\Services\Workspace;

use App\Contexts\MobileAppBack\Infrastructure\ACL\Collaboration\MonolithCollaborationAdapter;

class CollaborationAppService
{
    public function __construct(
        private MonolithCollaborationAdapter $collaborationAdapter,
    ) {
    }

    public function propose(string $keeperId, string $memberId, string $workspaceId)
    {
        return $this->collaborationAdapter->propose($keeperId, $memberId, $workspaceId);
    }

    public function accept(string $inviteId)
    {
        return $this->collaborationAdapter->accept($inviteId);
    }

    public function reject(string $inviteId)
    {
        return $this->collaborationAdapter->reject($inviteId);
    }

    public function discard(string $inviteId)
    {
        return $this->collaborationAdapter->discard($inviteId);
    }

    public function leave(string $relationId)
    {
        return $this->collaborationAdapter->leave($relationId);
    }

}
