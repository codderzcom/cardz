<?php

namespace App\Contexts\Collaboration\Application\Commands\Invite;

use App\Contexts\Collaboration\Domain\Model\Invite\InviteId;
use App\Shared\Contracts\Commands\CommandInterface;

interface InviteCommandInterface extends CommandInterface
{
    public function getInviteId(): InviteId;
}
