<?php

namespace App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\Commands;

final class ChangePlanRequirementDescriptionRequest extends PlanCommandRequest
{
    protected const RULES = [
        'requirementId' => 'required',
        'description' => 'required',
    ];

    protected const MESSAGES = [
        'requirementId.required' => 'requirementId required',
        'description.required' => 'description required',
    ];

    public string $requirementId;

    public string $description;

    public function passedValidation(): void
    {
        parent::passedValidation();
        $this->requirementId = $this->input('requirementId');
        $this->description = $this->input('description');
    }

    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();
        $this->merge([
            'requirementId' => $this->route('requirementId'),
        ]);
    }
}
