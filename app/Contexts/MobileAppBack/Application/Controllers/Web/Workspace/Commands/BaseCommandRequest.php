<?php

namespace App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\Commands;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseCommandRequest extends FormRequest
{
    protected const RULES = [
        'workspaceId' => 'required',
        'keeperId' => 'required',
    ];

    protected const MESSAGES = [
        'workspaceId.required' => 'workspaceId required',
        'keeperId.required' => 'keeperId required',
    ];

    public string $workspaceId;

    public string $keeperId;

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
        $this->keeperId = $this->input('keeperId');
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'workspaceId' => $this->route('workspaceId'),
            'keeperId' => $this->user()->id,
        ]);
    }

}
