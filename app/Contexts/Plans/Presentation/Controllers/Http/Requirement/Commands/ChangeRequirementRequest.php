<?php

namespace App\Contexts\Plans\Presentation\Controllers\Http\Requirement\Commands;

use App\Contexts\Plans\Application\Commands\Requirement\ChangeRequirement;

final class ChangeRequirementRequest extends BaseCommandRequest
{
    protected const RULES = [
        'description' => 'required',
    ];

    protected const MESSAGES = [
        'description.required' => 'descriptions required',
    ];

    protected string $requirementId;

    protected string $description;

    public function passedValidation(): void
    {
        parent::passedValidation();
        $this->description = $this->input('description');
    }

    public function toCommand(): ChangeRequirement
    {
        return ChangeRequirement::of($this->requirementId, $this->description);
    }
}
