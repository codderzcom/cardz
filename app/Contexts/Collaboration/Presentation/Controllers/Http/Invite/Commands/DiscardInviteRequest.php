<?php

namespace App\Contexts\Collaboration\Presentation\Controllers\Http\Invite\Commands;

use App\Contexts\Collaboration\Application\Commands\Invite\DiscardInvite;
use App\Contexts\Collaboration\Application\Commands\Invite\DiscardInviteCommandInterface;

class DiscardInviteRequest extends InviteRequest
{
    public function toCommand(): DiscardInviteCommandInterface
    {
        return DiscardInvite::of($this->inviteId);
    }
}
