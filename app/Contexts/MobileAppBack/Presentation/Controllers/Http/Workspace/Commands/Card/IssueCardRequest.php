<?php

namespace App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Commands\Card;

use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Commands\BaseCommandRequest;

final class IssueCardRequest extends BaseCommandRequest
{
    protected const RULES = [
        'planId' => 'required',
        'customerId' => 'required',
        'description' => 'required',
    ];

    protected const MESSAGES = [
        'planId.required' => 'planId required',
        'customerId.required' => 'customerId required',
        'description.required' => 'description required',
    ];

    public string $customerId;

    public string $planId;

    public string $description;

    public function passedValidation(): void
    {
        parent::passedValidation();
        $this->planId = $this->input('planId');
        $this->customerId = $this->input('customerId');
        $this->description = $this->input('description');
    }
}
