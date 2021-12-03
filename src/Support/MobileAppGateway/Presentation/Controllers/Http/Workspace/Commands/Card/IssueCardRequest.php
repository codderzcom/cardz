<?php

namespace Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Commands\Card;

use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Commands\BaseCommandRequest;
use Codderz\Platypus\Contracts\GeneralIdInterface;
use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;

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
