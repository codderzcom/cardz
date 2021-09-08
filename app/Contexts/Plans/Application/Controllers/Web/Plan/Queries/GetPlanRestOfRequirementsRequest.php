<?php

namespace App\Contexts\Plans\Application\Controllers\Web\Plan\Queries;

final class GetPlanRestOfRequirementsRequest extends BaseQueryRequest
{
    protected const RULES = [
        'requirementIds' => 'required',
    ];

    protected const MESSAGES = [
        'requirementIds.required' => 'requirementIds required',
    ];

    public array $requirementIds = [];

    public function passedValidation(): void
    {
        parent::passedValidation();
        $this->requirementIds = $this->input('requirementIds');
    }
}
