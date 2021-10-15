<?php

namespace App\Contexts\Collaboration\Presentation\Controllers\Http\Invite\Commands;

use App\Contexts\Collaboration\Application\Commands\Invite\RejectInvite;
use App\Contexts\Collaboration\Application\Commands\Invite\RejectInviteCommandInterface;

class RejectInviteRequest extends InviteRequest
{
    public function toCommand(): RejectInviteCommandInterface
    {
        return RejectInvite::of($this->inviteId);
    }
}
