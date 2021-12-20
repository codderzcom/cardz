<?php

namespace Cardz\Support\MobileAppGateway\Application\Services\Workspace;

use Cardz\Support\MobileAppGateway\Integration\Contracts\CollaborationContextInterface;

class CollaborationAppService
{
    public function __construct(
        private CollaborationContextInterface $collaborationContext,
    ) {
    }

    public function propose(string $collaboratorId, string $workspaceId): string
    {
        return $this->collaborationContext->propose($collaboratorId, $workspaceId);
    }

    public function accept(string $collaboratorId, string $inviteId): string
    {
        return $this->collaborationContext->accept($inviteId, $collaboratorId);
    }

    public function discard(string $inviteId): string
    {
        return $this->collaborationContext->discard($inviteId);
    }

    public function leave(string $collaboratorId, string $workspaceId): string
    {
        return $this->collaborationContext->leave($collaboratorId, $workspaceId);
    }

    public function fire(string $collaboratorId, string $workspaceId): string
    {
        return $this->collaborationContext->fire($collaboratorId, $workspaceId);
    }

}
