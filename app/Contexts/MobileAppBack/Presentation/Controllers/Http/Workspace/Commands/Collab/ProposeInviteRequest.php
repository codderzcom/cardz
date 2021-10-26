<?php

namespace App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Commands\Collab;

use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Commands\BaseCommandRequest;

final class ProposeInviteRequest extends BaseCommandRequest
{
    protected const RULES = [
        'memberId' => 'required',
    ];

    protected const MESSAGES = [
        'memberId.required' => 'memberId required',
    ];

    public string $memberId;

    public function passedValidation(): void
    {
        parent::passedValidation();
        $this->memberId = $this->input('memberId');
    }

}
