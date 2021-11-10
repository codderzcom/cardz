<?php

namespace App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Commands\Collaboration;

use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Commands\BaseCommandRequest;
use App\Shared\Contracts\GeneralIdInterface;
use App\Shared\Infrastructure\Support\GuidBasedImmutableId;

final class InviteRequest extends BaseCommandRequest
{
    protected const RULES = [
        'inviteId' => 'required',
    ];

    protected const MESSAGES = [
        'inviteId.required' => 'inviteId required',
    ];

    public GeneralIdInterface $inviteId;

    public function passedValidation(): void
    {
        parent::passedValidation();
        $this->inviteId = GuidBasedImmutableId::of($this->input('inviteId'));
    }

    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();
        $this->merge([
            'inviteId' => $this->route('inviteId'),
        ]);
    }
}
