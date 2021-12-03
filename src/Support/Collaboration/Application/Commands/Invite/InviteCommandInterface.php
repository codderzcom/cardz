<?php

namespace Cardz\Support\Collaboration\Application\Commands\Invite;

use Cardz\Support\Collaboration\Domain\Model\Invite\InviteId;
use Codderz\Platypus\Contracts\Commands\CommandInterface;

interface InviteCommandInterface extends CommandInterface
{
    public function getInviteId(): InviteId;
}
