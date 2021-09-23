<?php

namespace App\Contexts\Plans\Application\Controllers\Web\Requirement\Commands;

final class ChangeRequirementRequest extends BaseCommandRequest
{
    protected const RULES = [
        'requirementId' => 'required',
        'description' => 'required',
    ];

    protected const MESSAGES = [
        'requirementId.required' => 'requirementId required',
        'description.required' => 'descriptions required',
    ];

    public string $requirementId;

    public string $description;

    public function passedValidation(): void
    {
        parent::passedValidation();
        $this->requirementId = $this->input('requirementId');
        $this->description = $this->input('description');
    }
}
