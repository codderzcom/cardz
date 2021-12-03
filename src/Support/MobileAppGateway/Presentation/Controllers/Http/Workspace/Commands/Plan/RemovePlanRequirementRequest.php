<?php

namespace Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Commands\Plan;

use Codderz\Platypus\Contracts\GeneralIdInterface;
use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;

final class RemovePlanRequirementRequest extends PlanCommandRequest
{
    protected const RULES = [
        'requirementId' => 'required',
    ];

    protected const MESSAGES = [
        'requirementId.required' => 'requirementId required',
    ];

    public GeneralIdInterface $requirementId;

    public function passedValidation(): void
    {
        parent::passedValidation();
        $this->requirementId = GuidBasedImmutableId::of($this->input('requirementId'));
    }

    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();
        $this->merge([
            'requirementId' => $this->route('requirementId'),
        ]);
    }
}
