<?php

namespace Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Commands\Collaboration;

use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Commands\BaseCommandRequest;
use Codderz\Platypus\Contracts\GenericIdInterface;
use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;

final class InviteRequest extends BaseCommandRequest
{
    protected const RULES = [
        'inviteId' => 'required',
    ];

    protected const MESSAGES = [
        'inviteId.required' => 'inviteId required',
    ];

    public GenericIdInterface $inviteId;

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
