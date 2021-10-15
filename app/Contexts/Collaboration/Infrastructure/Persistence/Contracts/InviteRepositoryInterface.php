<?php

namespace App\Contexts\Collaboration\Infrastructure\Persistence\Contracts;

use App\Contexts\Collaboration\Domain\Model\Invite\Invite;
use App\Contexts\Collaboration\Domain\Model\Invite\InviteId;

interface InviteRepositoryInterface
{
    public function persist(Invite $invite): void;

    public function take(InviteId $inviteId): ?Invite;

    public function remove(InviteId $inviteId): void;
}
