<?php

namespace App\Contexts\Plans\Presentation\Controllers\Http\Requirement\Commands;

use App\Contexts\Plans\Domain\Model\Requirement\RequirementId;
use Illuminate\Foundation\Http\FormRequest;

abstract class BaseCommandRequest extends FormRequest
{
    protected const RULES = [
        'planId' => 'required',
        'requirementId' => 'required',
    ];

    protected const MESSAGES = [
        'planId.required' => 'planId required',
        'requirementId.required' => 'requirementId required',
    ];

    protected string $planId;

    protected string $requirementId;

    public function rules(): array
    {
        return array_merge(self::RULES, static::RULES);
    }

    public function messages(): array
    {
        return array_merge(self::MESSAGES, static::MESSAGES);
    }

    public function passedValidation(): void
    {
        $this->planId = $this->input('planId');
        $this->requirementId = $this->input('requirementId');
    }

    public function getRequirementId(): RequirementId
    {
        return RequirementId::of($this->requirementId);
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'planId' => $this->route('planId'),
            'requirementId' => $this->route('requirementId'),
        ]);
    }

}
