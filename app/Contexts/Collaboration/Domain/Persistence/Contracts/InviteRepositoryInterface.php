<?php

namespace App\Contexts\Collaboration\Domain\Persistence\Contracts;

use App\Contexts\Collaboration\Domain\Exceptions\InviteNotFoundExceptionInterface;
use App\Contexts\Collaboration\Domain\Model\Invite\Invite;
use App\Contexts\Collaboration\Domain\Model\Invite\InviteId;

interface InviteRepositoryInterface
{
    public function persist(Invite $invite): void;

    /**
     * @throws InviteNotFoundExceptionInterface
     */
    public function take(InviteId $inviteId): Invite;
}
