<?php

namespace Cardz\Support\Collaboration\Domain\Persistence\Contracts;

use Cardz\Support\Collaboration\Domain\Exceptions\InviteNotFoundExceptionInterface;
use Cardz\Support\Collaboration\Domain\Model\Invite\Invite;
use Cardz\Support\Collaboration\Domain\Model\Invite\InviteId;

interface InviteRepositoryInterface
{
    public function persist(Invite $invite): void;

    /**
     * @throws InviteNotFoundExceptionInterface
     */
    public function take(InviteId $inviteId): Invite;
}
