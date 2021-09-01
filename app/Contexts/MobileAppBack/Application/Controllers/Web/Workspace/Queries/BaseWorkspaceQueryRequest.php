<?php

namespace App\Contexts\MobileAppBack\Application\Controllers\Web\Customer\Queries;

use Illuminate\Foundation\Http\FormRequest;

class BaseWorkspaceQueryRequest extends FormRequest
{
    protected const RULES = [
        'workspaceId' => 'required',
    ];

    protected const MESSAGES = [
        'workspaceId.required' => 'workspaceId required',
    ];

    public string $workspaceId;

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
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'workspaceId' => $this->route('workspaceId'),
        ]);
    }

}
