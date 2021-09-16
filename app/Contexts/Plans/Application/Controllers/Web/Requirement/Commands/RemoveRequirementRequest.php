<?php

namespace App\Contexts\Plans\Application\Controllers\Web\Requirement\Commands;

final class RemoveRequirementRequest extends BaseCommandRequest
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

}
