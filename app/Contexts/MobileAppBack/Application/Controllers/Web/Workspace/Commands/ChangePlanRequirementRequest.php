<?php

namespace App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\Commands;

final class ChangePlanRequirementRequest extends PlanCommandRequest
{
    protected const RULES = [
        'description' => 'required',
    ];

    protected const MESSAGES = [
        'description.required' => 'description required',
    ];

    /**
     * @var string[]
     */
    public array $descriptions = [];

    public function passedValidation(): void
    {
        parent::passedValidation();
        $this->description = $this->input('description');
    }
}
