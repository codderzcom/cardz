<?php

namespace App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\Commands\Collab;

use App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\Commands\BaseCommandRequest;

final class InviteRequest extends BaseCommandRequest
{
    protected const RULES = [
        'inviteId' => 'required',
    ];

    protected const MESSAGES = [
        'inviteId.required' => 'inviteId required',
    ];

    public string $inviteId;

    public function passedValidation(): void
    {
        parent::passedValidation();
        $this->inviteId = $this->input('inviteId');
    }
}
