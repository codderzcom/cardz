<?php

namespace App\Contexts\Collaboration\Tests\Support\Mocks;

use App\Contexts\Collaboration\Domain\Model\Invite\Invite;
use App\Contexts\Collaboration\Domain\Model\Invite\InviteId;
use App\Contexts\Collaboration\Domain\Persistence\Contracts\InviteRepositoryInterface;

class InviteInMemoryRepository implements InviteRepositoryInterface
{
    protected static array $storage = [];

    public function persist(Invite $invite): void
    {
        if ($invite->isAccepted() || $invite->isDiscarded()) {
            unset(static::$storage[(string) $invite->inviteId]);
            return;
        }
        static::$storage[(string) $invite->inviteId] = $invite;
    }

    public function take(InviteId $inviteId): Invite
    {
        return static::$storage[(string) $inviteId];
    }
}
