<?php

namespace Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Commands\Plan;

final class ChangePlanProfileRequest extends PlanCommandRequest
{
    protected const RULES = [
        'name' => 'required',
        'description' => 'required',
    ];

    protected const MESSAGES = [
        'name.required' => 'name required',
        'description.required' => 'description required',
    ];

    public string $description;

    public string $name;

    public function passedValidation(): void
    {
        parent::passedValidation();
        $this->name = $this->input('name');
        $this->description = $this->input('description');
    }
}
