<?php

namespace Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Commands\Plan;

use Codderz\Platypus\Contracts\GeneralIdInterface;
use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;

final class ChangePlanRequirementDescriptionRequest extends PlanCommandRequest
{
    protected const RULES = [
        'requirementId' => 'required',
        'description' => 'required',
    ];

    protected const MESSAGES = [
        'requirementId.required' => 'requirementId required',
        'description.required' => 'description required',
    ];

    public GeneralIdInterface $requirementId;

    public string $description;

    public function passedValidation(): void
    {
        parent::passedValidation();
        $this->requirementId = GuidBasedImmutableId::of($this->input('requirementId'));
        $this->description = $this->input('description');
    }

    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();
        $this->merge([
            'requirementId' => $this->route('requirementId'),
        ]);
    }
}
