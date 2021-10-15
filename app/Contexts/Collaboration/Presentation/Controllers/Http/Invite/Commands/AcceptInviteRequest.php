<?php

namespace App\Contexts\Collaboration\Presentation\Controllers\Http\Invite\Commands;

use App\Contexts\Collaboration\Application\Commands\Invite\AcceptInvite;
use App\Contexts\Collaboration\Application\Commands\Invite\AcceptInviteCommandInterface;

class AcceptInviteRequest extends InviteRequest
{
    public function toCommand(): AcceptInviteCommandInterface
    {
        return AcceptInvite::of($this->inviteId);
    }
}
