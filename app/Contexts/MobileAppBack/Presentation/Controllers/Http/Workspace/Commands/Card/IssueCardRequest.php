<?php

namespace App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Commands\Card;

use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Commands\BaseCommandRequest;
use App\Shared\Contracts\GeneralIdInterface;
use App\Shared\Infrastructure\Support\GuidBasedImmutableId;

final class IssueCardRequest extends BaseCommandRequest
{
    protected const RULES = [
        'planId' => 'required',
        'customerId' => 'required',
    ];

    protected const MESSAGES = [
        'planId.required' => 'planId required',
        'customerId.required' => 'customerId required',
    ];

    public GeneralIdInterface $customerId;

    public GeneralIdInterface $planId;

    public function passedValidation(): void
    {
        parent::passedValidation();
        $this->planId = GuidBasedImmutableId::of($this->input('planId'));
        $this->customerId = GuidBasedImmutableId::of($this->input('customerId'));
    }
}
