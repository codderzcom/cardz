<?php

namespace Cardz\Support\Collaboration\Presentation\Controllers\Http\Invite\Commands;

use Cardz\Support\Collaboration\Application\Commands\Invite\ProposeInvite;
use Illuminate\Foundation\Http\FormRequest;

final class ProposeInviteRequest extends FormRequest
{
    public string $keeperId;

    public string $workspaceId;

    public function rules(): array
    {
        return [
            'keeperId' => 'required',
            'workspaceId' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'keeperId.required' => 'keeperId required',
            'workspaceId.required' => 'workspaceId required',
        ];
    }

    public function passedValidation(): void
    {
        $this->keeperId = $this->input('keeperId');
        $this->workspaceId = $this->input('workspaceId');
    }

    public function toCommand(): ProposeInvite
    {
        return ProposeInvite::of($this->keeperId, $this->workspaceId);
    }

}
