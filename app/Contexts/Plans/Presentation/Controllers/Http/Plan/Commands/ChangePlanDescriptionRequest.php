<?php

namespace App\Contexts\Plans\Presentation\Controllers\Http\Plan\Commands;

use App\Contexts\Plans\Application\Commands\Plan\ChangePlanDescription;

final class ChangePlanDescriptionRequest extends BaseCommandRequest
{
    protected const RULES = [
        'description' => 'required',
    ];

    protected const MESSAGES = [
        'description.required' => 'description required',
    ];

    private string $description;

    public function passedValidation(): void
    {
        parent::passedValidation();
        $this->description = $this->input('description');
    }

    public function toCommand(): ChangePlanDescription
    {
        return ChangePlanDescription::of($this->planId, $this->description);
    }
}
