<?php

namespace App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\Commands;

final class ChangePlanRequirementsRequest extends PlanCommandRequest
{
    protected const RULES = [
        'descriptions' => 'required',
    ];

    protected const MESSAGES = [
        'descriptions.required' => 'descriptions required',
    ];

    /**
     * @var string[]
     */
    public array $descriptions = [];

    public function passedValidation(): void
    {
        parent::passedValidation();
        $this->descriptions = $this->input('descriptions');
    }
}
