<?php

namespace App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Commands;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseCommandRequest extends FormRequest
{
    protected const RULES = [
        'workspaceId' => 'required',
        'collaboratorId' => 'required',
    ];

    protected const MESSAGES = [
        'workspaceId.required' => 'workspaceId required',
        'collaboratorId.required' => 'collaboratorId required',
    ];

    public string $workspaceId;

    public string $collaboratorId;

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
        $this->workspaceId = $this->input('workspaceId');
        $this->collaboratorId = $this->input('collaboratorId');
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'workspaceId' => $this->route('workspaceId'),
            'collaboratorId' => $this->user()->id,
        ]);
    }

}
