<?php

namespace App\Contexts\Collaboration\Tests\Support\Builders;

use App\Contexts\Collaboration\Domain\Model\Invite\Invite;
use App\Contexts\Collaboration\Domain\Model\Invite\InviteId;
use App\Contexts\Collaboration\Domain\Model\Invite\InviterId;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;
use App\Shared\Infrastructure\Tests\BaseBuilder;
use Carbon\Carbon;

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
