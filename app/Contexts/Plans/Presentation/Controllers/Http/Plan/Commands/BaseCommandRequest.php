<?php

namespace App\Contexts\Plans\Presentation\Controllers\Http\Plan\Commands;

use App\Contexts\Plans\Domain\Model\Plan\PlanId;
use Illuminate\Foundation\Http\FormRequest;

abstract class BaseCommandRequest extends FormRequest
{
    protected const RULES = [
        'planId' => 'required',
    ];

    protected const MESSAGES = [
        'planId.required' => 'planId required',
    ];

    protected string $planId;

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
    }

    public function getPlanId(): PlanId
    {
        return PlanId::of($this->planId);
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'planId' => $this->route('planId'),
        ]);
    }

}
