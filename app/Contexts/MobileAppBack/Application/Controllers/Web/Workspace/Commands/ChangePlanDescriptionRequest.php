<?php

namespace App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\Commands;

final class ChangePlanDescriptionRequest extends PlanCommandRequest
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

    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();
        $this->merge([
            'description' => $this->input('description'),
        ]);
    }
}
