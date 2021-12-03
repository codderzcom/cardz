<?php

namespace Cardz\Support\Collaboration\Application\Commands\Invite;

use Cardz\Support\Collaboration\Domain\Model\Invite\InviteId;
use Cardz\Support\Collaboration\Domain\Model\Workspace\KeeperId;
use Cardz\Support\Collaboration\Domain\Model\Workspace\WorkspaceId;

final class ProposeInvite implements InviteCommandInterface
{
    private function __construct(
        private string $inviteId,
        private string $keeperId,
        private string $workspaceId,
    ) {
    }

    public static function of(string $keeperId, string $workspaceId): self
    {
        return new self(InviteId::makeValue(), $keeperId, $workspaceId);
    }

    public function getInviteId(): InviteId
    {
        return InviteId::of($this->inviteId);
    }

    public function getKeeperId(): KeeperId
    {
        return KeeperId::of($this->keeperId);
    }

    public function getWorkspaceId(): WorkspaceId
    {
        return WorkspaceId::of($this->workspaceId);
    }
}
