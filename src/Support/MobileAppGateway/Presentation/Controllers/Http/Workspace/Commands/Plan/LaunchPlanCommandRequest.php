<?php

namespace Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Commands\Plan;

use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Commands\BaseCommandRequest;
use Codderz\Platypus\Contracts\GenericIdInterface;
use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;

class LaunchPlanCommandRequest extends BaseCommandRequest
{
    protected const RULES = [
        'planId' => 'required',
        'expirationDate' => 'required|date|after:tomorrow',
    ];

    protected const MESSAGES = [
        'planId.required' => 'planId required',
        'expirationDate.required' => 'expirationDate required',
        'expirationDate.date' => 'expirationDate should be a date',
        'expirationDate.after' => 'expirationDate should be a date after tomorrow',
    ];

    public GenericIdInterface $planId;

    public string $expirationDate;

    public function rules(): array
    {
        return array_merge(parent::rules(), self::RULES, static::RULES);
    }

    public function messages(): array
    {
        return array_merge(parent::messages(), self::MESSAGES, static::MESSAGES);
    }

    public function passedValidation(): void
    {
        parent::passedValidation();
        $this->planId = GuidBasedImmutableId::of($this->input('planId'));
        $this->expirationDate = $this->input('expirationDate');
    }

    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();
        $this->merge([
            'planId' => $this->route('planId'),
        ]);
    }
}
