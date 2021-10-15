<?php

namespace App\Contexts\Collaboration\Infrastructure\ReadStorage\Contracts;

use App\Contexts\Collaboration\Domain\ReadModel\AcceptedInvite;

interface AcceptedInviteReadStorageInterface
{
    public function take(string $inviteId): ?AcceptedInvite;

    public function find(string $memberId, string $workspaceId): ?AcceptedInvite;
}
