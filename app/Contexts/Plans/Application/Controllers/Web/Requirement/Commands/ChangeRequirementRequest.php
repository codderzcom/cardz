<?php

namespace App\Contexts\Plans\Application\Controllers\Web\Requirement\Commands;

final class ChangeRequirementRequest extends BaseCommandRequest
{
    protected const RULES = [
        'description' => 'required',
    ];

    protected const MESSAGES = [
        'description.required' => 'description required',
    ];

    public string $description;

    public function passedValidation(): void
    {
        parent::passedValidation();
        $this->description = $this->input('description');
    }

}
