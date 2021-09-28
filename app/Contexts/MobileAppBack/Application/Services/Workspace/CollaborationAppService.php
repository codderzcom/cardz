<?php

namespace App\Contexts\MobileAppBack\Application\Services\Workspace;

use App\Contexts\MobileAppBack\Infrastructure\ACL\Collaboration\CollaborationAdapter;
use App\Contexts\Shared\Contracts\ServiceResultFactoryInterface;
use App\Contexts\Shared\Contracts\ServiceResultInterface;

class CollaborationAppService
{
    public function __construct(
        private CollaborationAdapter $collaborationAdapter,
        private ServiceResultFactoryInterface $serviceResultFactory,
    )
    {
    }

    public function propose(string $keeperId, string $memberId, string $workspaceId): ServiceResultInterface
    {
        return $this->collaborationAdapter->propose($keeperId, $memberId, $workspaceId);
    }

    public function accept(string $inviteId): ServiceResultInterface
    {
        return $this->collaborationAdapter->accept($inviteId);
    }

    public function reject(string $inviteId): ServiceResultInterface
    {
        return $this->collaborationAdapter->reject($inviteId);
    }

    public function discard(string $inviteId): ServiceResultInterface
    {
        return $this->collaborationAdapter->discard($inviteId);
    }

    public function leave(string $relationId): ServiceResultInterface
    {
        return $this->collaborationAdapter->leave($relationId);
    }

}
