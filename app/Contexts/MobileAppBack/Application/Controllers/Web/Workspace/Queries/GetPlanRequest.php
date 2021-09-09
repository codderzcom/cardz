<?php

namespace App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\Queries;

class GetPlanRequest extends BaseWorkspaceQueryRequest
{
    protected const RULES = [
        'planId' => 'required',
    ];

    protected const MESSAGES = [
        'planId.required' => 'planId required',
    ];

    public string $planId;

    public function passedValidation(): void
    {
        parent::passedValidation();
        $this->planId = $this->input('planId');
    }

    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();
        $this->merge([
            'planId' => $this->route('planId'),
        ]);
    }
}
