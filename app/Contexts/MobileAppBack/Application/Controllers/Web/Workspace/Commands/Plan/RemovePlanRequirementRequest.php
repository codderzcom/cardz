<?php

namespace App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\Commands\Plan;

final class RemovePlanRequirementRequest extends PlanCommandRequest
{
    protected const RULES = [
        'requirementId' => 'required',
    ];

    protected const MESSAGES = [
        'requirementId.required' => 'requirementId required',
    ];

    public string $requirementId;

    public function passedValidation(): void
    {
        parent::passedValidation();
        $this->requirementId = $this->input('requirementId');
    }

    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();
        $this->merge([
            'requirementId' => $this->route('requirementId'),
        ]);
    }
}
