<?php

namespace App\Contexts\Collaboration\Application\Commands\Invite;

use App\Contexts\Collaboration\Domain\Model\Relation\CollaboratorId;

interface AcceptInviteCommandInterface extends InviteCommandInterface
{
    public function getCollaboratorId(): CollaboratorId;
}
