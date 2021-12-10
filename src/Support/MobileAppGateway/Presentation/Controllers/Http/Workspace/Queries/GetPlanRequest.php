<?php

namespace Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Queries;

use Codderz\Platypus\Contracts\GenericIdInterface;
use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;

class GetPlanRequest extends BaseWorkspaceQueryRequest
{
    protected const RULES = [
        'planId' => 'required',
    ];

    protected const MESSAGES = [
        'planId.required' => 'planId required',
    ];

    public GenericIdInterface $planId;

    public function passedValidation(): void
    {
        parent::passedValidation();
        $this->planId = GuidBasedImmutableId::of($this->input('planId'));
    }

    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();
        $this->merge([
            'planId' => $this->route('planId'),
        ]);
    }
}
