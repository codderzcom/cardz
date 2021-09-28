<?php

namespace App\Contexts\Collaboration\Application\Controllers\Web\Invite\Commands;

use Illuminate\Foundation\Http\FormRequest;

final class InviteProposeRequest extends FormRequest
{
    public string $keeperId;
    public string $memberId;
    public string $workspaceId;

    public function rules(): array
    {
        return [
            'keeperId' => 'required',
            'memberId' => 'required',
            'workspaceId' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'keeperId.required' => 'keeperId required',
            'memberId.required' => 'memberId required',
            'workspaceId.required' => 'workspaceId required',
        ];
    }

    public function passedValidation(): void
    {
        $this->keeperId = $this->input('keeperId');
        $this->memberId = $this->input('memberId');
        $this->workspaceId = $this->input('workspaceId');
    }

}
