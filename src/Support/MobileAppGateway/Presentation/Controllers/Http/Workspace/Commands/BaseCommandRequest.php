<?php

namespace Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Commands;

use Codderz\Platypus\Contracts\GeneralIdInterface;
use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;
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

    public GeneralIdInterface $workspaceId;

    public GeneralIdInterface $collaboratorId;

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
        $this->workspaceId = GuidBasedImmutableId::of($this->input('workspaceId'));
        $this->collaboratorId = GuidBasedImmutableId::of($this->input('collaboratorId'));
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'workspaceId' => $this->route('workspaceId'),
            'collaboratorId' => $this->user()->id,
        ]);
    }

}
