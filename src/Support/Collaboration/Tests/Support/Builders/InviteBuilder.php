<?php

namespace Cardz\Support\Collaboration\Tests\Support\Builders;

use Carbon\Carbon;
use Cardz\Support\Collaboration\Domain\Model\Invite\Invite;
use Cardz\Support\Collaboration\Domain\Model\Invite\InviteId;
use Cardz\Support\Collaboration\Domain\Model\Invite\InviterId;
use Cardz\Support\Collaboration\Domain\Model\Workspace\WorkspaceId;
use Codderz\Platypus\Infrastructure\Tests\BaseBuilder;

final class InviteBuilder extends BaseBuilder
{
    public string $inviteId;

    public string $inviterId;

    public string $workspaceId;

    public Carbon $proposed;

    public function build(): Invite
    {
        return Invite::restore(
            $this->inviteId,
            $this->inviterId,
            $this->workspaceId,
            $this->proposed,
        );
    }

    public function withWorkspaceId(string $workspaceId): self
    {
        $this->workspaceId = $workspaceId;
        return $this;
    }

    public function withInviterId(string $inviterId): self
    {
        $this->inviterId = $inviterId;
        return $this;
    }

    public function generate(): static
    {
        $this->inviteId = InviteId::makeValue();
        $this->inviterId = InviterId::makeValue();
        $this->workspaceId = WorkspaceId::makeValue();
        $this->proposed = Carbon::now();
        return $this;
    }
}
