<?php

namespace Cardz\Support\Collaboration\Tests\Support\Mocks;

use Cardz\Support\Collaboration\Domain\Model\Invite\Invite;
use Cardz\Support\Collaboration\Domain\Model\Invite\InviteId;
use Cardz\Support\Collaboration\Domain\Persistence\Contracts\InviteRepositoryInterface;

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
