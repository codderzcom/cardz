<?php

namespace Cardz\Support\MobileAppGateway\Application\Services\Workspace;

use Cardz\Support\MobileAppGateway\Integration\Contracts\CollaborationContextInterface;

class CollaborationAppService
{
    public function __construct(
        private CollaborationContextInterface $collaborationContext,
    ) {
    }

    public function propose(string $collaboratorId, string $workspaceId)
    {
        return $this->collaborationContext->propose($collaboratorId, $workspaceId);
    }

    public function accept(string $collaboratorId, string $inviteId)
    {
        return $this->collaborationContext->accept($inviteId, $collaboratorId);
    }

    public function discard(string $inviteId)
    {
        return $this->collaborationContext->discard($inviteId);
    }

    public function leave(string $collaboratorId, string $workspaceId)
    {
        return $this->collaborationContext->leave($collaboratorId, $workspaceId);
    }

}
