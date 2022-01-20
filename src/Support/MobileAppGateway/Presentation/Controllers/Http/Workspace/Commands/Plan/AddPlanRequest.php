<?php

namespace Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Commands\Plan;

use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Commands\BaseCommandRequest;

final class AddPlanRequest extends BaseCommandRequest
{
    protected const RULES = [
        'name' => 'required',
        'description' => 'required',
    ];

    protected const MESSAGES = [
        'name.required' => 'name required',
        'description.required' => 'description required',
    ];

    public string $name;

    public string $description;

    public function passedValidation(): void
    {
        parent::passedValidation();
        $this->name = $this->input('name');
        $this->description = $this->input('description');
    }
}
